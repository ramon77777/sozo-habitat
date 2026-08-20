<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyMediaUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_request_a_presigned_upload(): void
    {
        $this->postJson(route('media.uploads.presign'), [
            'category' => 'main_image',
            'filename' => 'villa.jpg',
            'content_type' => 'image/jpeg',
            'size' => 1024,
        ])->assertUnauthorized();
    }

    public function test_invalid_media_type_is_rejected_before_signing(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($user)
            ->postJson(route('media.uploads.presign'), [
                'category' => 'main_image',
                'filename' => 'danger.svg',
                'content_type' => 'image/svg+xml',
                'size' => 1024,
            ])
            ->assertStatus(422)
            ->assertJsonPath(
                'errors.content_type.0',
                'Le type de fichier sÃ©lectionnÃ© nâ€™est pas autorisÃ©.'
            );
    }

    public function test_oversized_video_is_rejected_before_signing(): void
    {
        $user = User::factory()->create([
            'role' => 'agent',
        ]);

        $this->actingAs($user)
            ->postJson(route('media.uploads.presign'), [
                'category' => 'property_video',
                'filename' => 'visite.mp4',
                'content_type' => 'video/mp4',
                'size' => (501 * 1024 * 1024),
            ])
            ->assertStatus(422)
            ->assertJsonPath(
                'errors.size.0',
                'Le fichier dÃ©passe la limite de 500 Mo.'
            );
    }
}