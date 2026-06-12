<?php

namespace Tests\Feature;

use App\Models\Media;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed database for roles and default users
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * Test that guests cannot access the media manager.
     */
    public function test_guest_cannot_access_media_manager(): void
    {
        $response = $this->get('/admin/media');
        $response->assertRedirect('/login');
    }

    /**
     * Test that admin can upload a media file.
     */
    public function test_admin_can_upload_media_file(): void
    {
        // Fake public storage disk
        Storage::fake('public');

        $admin = User::where('email', 'admin@katedralsamarinda.org')->first();
        $file = UploadedFile::fake()->image('misa_katedral.jpg', 800, 600);

        $response = $this->actingAs($admin)->post('/admin/media', [
            'file' => $file,
        ]);

        $response->assertRedirect();
        
        // Assert the file was stored on the fake disk
        $media = Media::where('filename', 'misa_katedral.jpg')->first();
        $this->assertNotNull($media);
        Storage::disk('public')->assertExists($media->filepath);
    }

    /**
     * Test that admin can delete a media file.
     */
    public function test_admin_can_delete_media_file(): void
    {
        // Fake public storage disk
        Storage::fake('public');

        $admin = User::where('email', 'admin@katedralsamarinda.org')->first();
        $file = UploadedFile::fake()->image('delete_me.png');

        // Initial upload
        $this->actingAs($admin)->post('/admin/media', [
            'file' => $file,
        ]);

        $media = Media::where('filename', 'delete_me.png')->first();
        $this->assertNotNull($media);
        Storage::disk('public')->assertExists($media->filepath);

        // Delete
        $response = $this->actingAs($admin)->delete("/admin/media/{$media->id}");
        $response->assertRedirect();

        // Assert record and file are gone
        $this->assertDatabaseMissing('media', ['id' => $media->id]);
        Storage::disk('public')->assertMissing($media->filepath);
    }
}
