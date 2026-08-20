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
                'Le type de fichier sÃ©lectionnÃ© nâ€™est pas autorisÃ©.'
            );
        }

        if ($size < 1 || $size > $maximumSize) {
            $maximumMegabytes = (int) ceil($maximumSize / 1024 / 1024);

            $this->failValidation(
                'size',
                "Le fichier dÃ©passe la limite de {$maximumMegabytes} Mo."
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

        $disk = $this->disk();

        if (! $disk->providesTemporaryUploadUrls()) {
            throw new RuntimeException(
                'Le disque mÃ©dia ne permet pas de gÃ©nÃ©rer des URL dâ€™envoi temporaires.'
            );
        }

        $temporaryUpload = $disk->temporaryUploadUrl(
            $key,
            now()->addMinutes(15),
            ['ContentType' => $contentType]
        );

        return [
            'key' => $key,
            'url' => $temporaryUpload['url'],
            'headers' => $temporaryUpload['headers'] ?? [],
            'expires_at' => now()->addMinutes(15)->toIso8601String(),
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
                'Un bien ne peut pas contenir plus de 2 vidÃ©os.'
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
                'La rÃ©fÃ©rence du mÃ©dia nâ€™est pas valide pour cet utilisateur.'
            );
        }

        if ($this->pathIsAlreadyUsed($key)) {
            $this->failValidation(
                'media',
                'Ce mÃ©dia est dÃ©jÃ  associÃ© Ã  un bien.'
            );
        }

        $disk = $this->disk();

        try {
            if (! $disk->exists($key)) {
                $this->failValidation(
                    'media',
                    'Le mÃ©dia envoyÃ© est introuvable dans le stockage.'
                );
            }

            $size = $disk->size($key);

            if ($size < 1 || $size > $maximumSize) {
                $this->failValidation(
                    'media',
                    'La taille rÃ©elle du mÃ©dia nâ€™est pas autorisÃ©e.'
                );
            }

            $mimeType = $disk->mimeType($key);

            if (! in_array($mimeType, $allowedMimeTypes, true)) {
                $this->failValidation(
                    'media',
                    'Le type rÃ©el du mÃ©dia nâ€™est pas autorisÃ©.'
                );
            }
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            report($exception);

            $this->failValidation(
                'media',
                'Impossible de vÃ©rifier le mÃ©dia dans Cloudflare R2.'
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
                'La catÃ©gorie de mÃ©dia est invalide.'
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
            'La validation aurait dÃ» lever une exception.'
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
