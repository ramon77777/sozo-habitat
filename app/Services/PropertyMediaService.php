<?php

namespace App\Services;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyVideo;
use App\Models\User;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Throwable;
use Aws\S3\S3Client;

class PropertyMediaService
{
    public const MAX_TOTAL_IMAGES = 4;
    public const MAX_VIDEOS = 2;
    public const MAX_IMAGE_BYTES = 10 * 1024 * 1024;
    public const MAX_VIDEO_BYTES = 500 * 1024 * 1024;

    private const IMAGE_MIME_TYPES = [
        'image/jpeg',
        'image/png',
        'image/webp',
    ];

    private const VIDEO_MIME_TYPES = [
        'video/mp4',
        'video/webm',
        'video/quicktime',
    ];

    public function createPresignedUpload(
        User $user,
        string $category,
        string $filename,
        string $contentType,
        int $size
    ): array {
        $this->assertMediaActor($user);

        [$allowedMimeTypes, $maximumSize, $folder] = $this->rulesFor($category);

        if (! in_array($contentType, $allowedMimeTypes, true)) {
            $this->failValidation(
                'content_type',
                'Le type de fichier sélectionné n’est pas autorisé.'
            );
        }

        if ($size < 1 || $size > $maximumSize) {
            $maximumMegabytes = (int) ceil($maximumSize / 1024 / 1024);

            $this->failValidation(
                'size',
                "Le fichier dépasse la limite de {$maximumMegabytes} Mo."
            );
        }

        $extension = $this->extensionForMimeType($contentType);
        $key = sprintf(
            'properties/%d/%s/%s.%s',
            $user->id,
            $folder,
            (string) Str::uuid(),
            $extension
        );

        $r2 = config('filesystems.disks.r2');

        $requiredConfiguration = [
            'key',
            'secret',
            'region',
            'bucket',
            'endpoint',
        ];

        foreach ($requiredConfiguration as $configurationKey) {
            if (blank($r2[$configurationKey] ?? null)) {
                throw new RuntimeException(
                    "La configuration R2 [{$configurationKey}] est manquante."
                );
            }
        }

        $client = new S3Client([
            'version' => 'latest',
            'region' => $r2['region'],
            'endpoint' => $r2['endpoint'],
            'credentials' => [
                'key' => $r2['key'],
                'secret' => $r2['secret'],
            ],
            'use_path_style_endpoint' => (bool) (
                $r2['use_path_style_endpoint'] ?? false
            ),
        ]);

        $command = $client->getCommand('PutObject', [
            'Bucket' => $r2['bucket'],
            'Key' => $key,
            'ContentType' => $contentType,
        ]);

        $expiresAt = now()->addMinutes(15);

        $request = $client->createPresignedRequest(
            $command,
            '+15 minutes'
        );

        return [
            'key' => $key,
            'url' => (string) $request->getUri(),
            'headers' => [
                'Content-Type' => $contentType,
            ],
            'expires_at' => $expiresAt->toIso8601String(),
            'filename' => $filename,
        ];
    }

    public function attachUploads(
        Property $property,
        User $actor,
        ?string $mainImageKey,
        array $galleryImageKeys,
        array $videoKeys
    ): void {
        $this->authorizeProperty($actor, $property);

        $galleryImageKeys = array_values(array_filter($galleryImageKeys));
        $videoKeys = array_values(array_filter($videoKeys));

        $currentImageCount = ($property->main_image ? 1 : 0)
            + $property->images()->count();

        $newImageCount = count($galleryImageKeys);

        if ($mainImageKey && ! $property->main_image) {
            $newImageCount++;
        }

        if (($currentImageCount + $newImageCount) > self::MAX_TOTAL_IMAGES) {
            $this->failValidation(
                'gallery_image_keys',
                'Un bien ne peut pas contenir plus de 4 images au total.'
            );
        }

        if (($property->videos()->count() + count($videoKeys)) > self::MAX_VIDEOS) {
            $this->failValidation(
                'property_video_keys',
                'Un bien ne peut pas contenir plus de 2 vidéos.'
            );
        }

        if ($mainImageKey) {
            $this->validateUploadedObject($actor, $mainImageKey, 'main_image');
        }

        foreach ($galleryImageKeys as $key) {
            $this->validateUploadedObject($actor, $key, 'gallery_image');
        }

        foreach ($videoKeys as $key) {
            $this->validateUploadedObject($actor, $key, 'property_video');
        }

        $oldMainImage = null;

        if ($mainImageKey) {
            $oldMainImage = $property->main_image;
            $property->forceFill(['main_image' => $mainImageKey])->save();
        }

        $nextImageOrder = ((int) $property->images()->max('sort_order')) + 1;

        foreach ($galleryImageKeys as $key) {
            $property->images()->create([
                'image_path' => $key,
                'is_main' => false,
                'sort_order' => $nextImageOrder++,
            ]);
        }

        $nextVideoOrder = ((int) $property->videos()->max('sort_order')) + 1;

        foreach ($videoKeys as $key) {
            $property->videos()->create([
                'video_path' => $key,
                'sort_order' => $nextVideoOrder++,
            ]);
        }

        if ($oldMainImage && $oldMainImage !== $mainImageKey) {
            $this->deletePath($oldMainImage, 'images/properties');
        }
    }

    public function deleteImage(PropertyImage $image): void
    {
        $this->deletePath($image->image_path, 'images/properties/gallery');
        $image->delete();
    }

    public function deleteVideo(PropertyVideo $video): void
    {
        $this->deletePath($video->video_path, 'videos/properties');
        $video->delete();
    }

    public function deleteAllForProperty(Property $property): void
    {
        $property->loadMissing(['images', 'videos']);

        $this->deletePath($property->main_image, 'images/properties');

        foreach ($property->images as $image) {
            $this->deletePath($image->image_path, 'images/properties/gallery');
        }

        foreach ($property->videos as $video) {
            $this->deletePath($video->video_path, 'videos/properties');
        }
    }

    public function authorizeProperty(User $user, Property $property): void
    {
        if ($user->role === 'admin') {
            return;
        }

        if (
            $user->role === 'agent'
            && (int) $property->user_id === (int) $user->id
        ) {
            return;
        }

        abort(403);
    }

    public function disk(): FilesystemAdapter
    {
        return Storage::disk(
            config('filesystems.media_disk', 'r2')
        );
    }

    private function validateUploadedObject(
        User $user,
        string $key,
        string $category
    ): void {
        [$allowedMimeTypes, $maximumSize, $folder] = $this->rulesFor($category);

        $expectedPrefix = sprintf(
            'properties/%d/%s/',
            $user->id,
            $folder
        );

        if (
            ! str_starts_with($key, $expectedPrefix)
            || str_contains($key, '..')
            || str_contains($key, '\\')
        ) {
            $this->failValidation(
                'media',
                'La référence du média n’est pas valide pour cet utilisateur.'
            );
        }

        if ($this->pathIsAlreadyUsed($key)) {
            $this->failValidation(
                'media',
                'Ce média est déjà associé à un bien.'
            );
        }

        $disk = $this->disk();

        try {
            if (! $disk->exists($key)) {
                $this->failValidation(
                    'media',
                    'Le média envoyé est introuvable dans le stockage.'
                );
            }

            $size = $disk->size($key);

            if ($size < 1 || $size > $maximumSize) {
                $this->failValidation(
                    'media',
                    'La taille réelle du média n’est pas autorisée.'
                );
            }

            $mimeType = $disk->mimeType($key);

            if (! in_array($mimeType, $allowedMimeTypes, true)) {
                $this->failValidation(
                    'media',
                    'Le type réel du média n’est pas autorisé.'
                );
            }
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            report($exception);

            $this->failValidation(
                'media',
                'Impossible de vérifier le média dans Cloudflare R2.'
            );
        }
    }

    private function deletePath(?string $path, string $legacyDirectory): void
    {
        if (! $path) {
            return;
        }

        if ($this->isManagedR2Path($path)) {
            $this->disk()->delete($path);

            return;
        }

        $legacyPath = public_path(
            trim($legacyDirectory, '/').'/'.$path
        );

        if (is_file($legacyPath)) {
            @unlink($legacyPath);
        }
    }

    private function isManagedR2Path(string $path): bool
    {
        return str_starts_with($path, 'properties/');
    }

    private function pathIsAlreadyUsed(string $key): bool
    {
        return Property::where('main_image', $key)->exists()
            || PropertyImage::where('image_path', $key)->exists()
            || PropertyVideo::where('video_path', $key)->exists();
    }

    private function assertMediaActor(User $user): void
    {
        abort_unless(
            in_array($user->role, ['admin', 'agent'], true),
            403
        );
    }

    private function rulesFor(string $category): array
    {
        return match ($category) {
            'main_image' => [
                self::IMAGE_MIME_TYPES,
                self::MAX_IMAGE_BYTES,
                'main',
            ],
            'gallery_image' => [
                self::IMAGE_MIME_TYPES,
                self::MAX_IMAGE_BYTES,
                'gallery',
            ],
            'property_video' => [
                self::VIDEO_MIME_TYPES,
                self::MAX_VIDEO_BYTES,
                'videos',
            ],
            default => $this->failValidation(
                'category',
                'La catégorie de média est invalide.'
            ),
        };
    }

    private function failValidation(
        string $key,
        string $message
    ): never {
        $validator = Validator::make(
            [$key => null],
            [$key => ['required']],
            ["{$key}.required" => $message]
        );

        $validator->validate();

        throw new RuntimeException(
            'La validation aurait dû lever une exception.'
        );
    }

    private function extensionForMimeType(string $mimeType): string
    {
        return match ($mimeType) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'video/mp4' => 'mp4',
            'video/webm' => 'webm',
            'video/quicktime' => 'mov',
            default => $this->failValidation(
                'content_type',
                'Le type de fichier est invalide.'
            ),
        };
    }
}
