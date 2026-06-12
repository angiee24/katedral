<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class PostLifecycleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed database for roles, permissions, categories, etc.
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * Test that guests cannot access the post management index.
     */
    public function test_guest_cannot_access_post_management(): void
    {
        $response = $this->get('/admin/berita');
        $response->assertRedirect('/login');
    }

    /**
     * Test that admin can view post list.
     */
    public function test_admin_can_view_post_list(): void
    {
        $admin = User::where('email', 'admin@katedralsamarinda.org')->first();
        
        $response = $this->actingAs($admin)->get('/admin/berita');
        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page->component('Admin/Berita/Index'));
    }

    /**
     * Test that admin can create a new post.
     */
    public function test_admin_can_create_post(): void
    {
        $admin = User::where('email', 'admin@katedralsamarinda.org')->first();
        $category = Category::first();

        $postData = [
            'title' => 'Test Misa Katedral',
            'excerpt' => 'Deskripsi ringkasan warta paroki',
            'content' => '<p>Konten detail warta paroki katedral samarinda.</p>',
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now()->format('Y-m-d H:i:s'),
            'is_featured' => 1,
        ];

        $response = $this->actingAs($admin)->post('/admin/berita', $postData);

        $response->assertRedirect('/admin/berita');
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Misa Katedral',
            'status' => 'published',
            'category_id' => $category->id,
        ]);
    }

    /**
     * Test that admin can update an existing post.
     */
    public function test_admin_can_update_post(): void
    {
        $admin = User::where('email', 'admin@katedralsamarinda.org')->first();
        $post = Post::first();
        $category = Category::first();

        $updatedData = [
            'title' => 'Judul Warta Diperbarui',
            'excerpt' => $post->excerpt,
            'content' => 'Konten baru yang diperbarui.',
            'category_id' => $category->id,
            'status' => 'draft',
            'is_featured' => 0,
        ];

        $response = $this->actingAs($admin)->put("/admin/berita/{$post->id}", $updatedData);

        $response->assertRedirect('/admin/berita');
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Judul Warta Diperbarui',
            'status' => 'draft',
        ]);
    }

    /**
     * Test that admin can delete a post.
     */
    public function test_admin_can_delete_post(): void
    {
        $admin = User::where('email', 'admin@katedralsamarinda.org')->first();
        $post = Post::first();

        $response = $this->actingAs($admin)->delete("/admin/berita/{$post->id}");

        $response->assertRedirect('/admin/berita');
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }
}
