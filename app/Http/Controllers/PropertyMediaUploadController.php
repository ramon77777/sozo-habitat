<?php

namespace App\Http\Controllers;

use App\Services\PropertyMediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PropertyMediaUploadController extends Controller
{
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

    public function __invoke(
        Request $request,
        PropertyMediaService $media
    ): JsonResponse {
        if (! $request->user()) {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $validated = $request->validate([
            'category' => [
                'required',
                Rule::in([
                    'main_image',
                    'gallery_image',
                    'property_video',
                ]),
            ],
            'filename' => ['required', 'string', 'max:255'],
            'content_type' => ['required', 'string', 'max:100'],
            'size' => ['required', 'integer', 'min:1'],
        ]);

        $categoryRules = $this->categoryRules(
            $validated['category']
        );

        if (! in_array(
            $validated['content_type'],
            $categoryRules['mime_types'],
            true
        )) {
            return $this->validationError(
                'content_type',
                'Le type de fichier sÃ©lectionnÃ© nâ€™est pas autorisÃ©.'
            );
        }

        if ($validated['size'] > $categoryRules['max_bytes']) {
            $maximumMegabytes = (int) ceil(
                $categoryRules['max_bytes'] / 1024 / 1024
            );

            return $this->validationError(
                'size',
                "Le fichier dÃ©passe la limite de {$maximumMegabytes} Mo."
            );
        }

        return response()->json(
            $media->createPresignedUpload(
                $request->user(),
                $validated['category'],
                $validated['filename'],
                $validated['content_type'],
                $validated['size']
            )
        );
    }

    private function categoryRules(string $category): array
    {
        return match ($category) {
            'main_image', 'gallery_image' => [
                'mime_types' => self::IMAGE_MIME_TYPES,
                'max_bytes' => PropertyMediaService::MAX_IMAGE_BYTES,
            ],
            'property_video' => [
                'mime_types' => self::VIDEO_MIME_TYPES,
                'max_bytes' => PropertyMediaService::MAX_VIDEO_BYTES,
            ],
        };
    }

    private function validationError(
        string $field,
        string $message
    ): JsonResponse {
        return response()->json([
            'message' => 'The given data was invalid.',
            'errors' => [
                $field => [$message],
            ],
        ], 422);
    }
}