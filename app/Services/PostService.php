<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PageView;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PostService
{
    
    public function createPost(array $data, int $userId): Post
    {
        return DB::transaction(function () use ($data, $userId) {
            $data['user_id'] = $userId;
            $data['slug'] = $this->generateUniqueSlug($data['title']);

            
            if ($data['status'] === 'published') {
                $data['published_at'] = $data['published_at'] ?? now();
            } elseif ($data['status'] === 'scheduled') {
                $data['published_at'] = Carbon::parse($data['published_at']);
            } else {
                $data['published_at'] = null;
            }

            $post = Post::create($data);

            if (isset($data['tags'])) {
                $post->tags()->sync($data['tags']);
            }

            return $post;
        });
    }

    
    public function updatePost(Post $post, array $data): Post
    {
        return DB::transaction(function () use ($post, $data) {
            if (isset($data['title']) && $data['title'] !== $post->title) {
                $data['slug'] = $this->generateUniqueSlug($data['title'], $post->id);
            }

            
            if (isset($data['status'])) {
                if ($data['status'] === 'published') {
                    $data['published_at'] = $data['published_at'] ?? $post->published_at ?? now();
                } elseif ($data['status'] === 'scheduled') {
                    $data['published_at'] = Carbon::parse($data['published_at']);
                } else {
                    $data['published_at'] = null;
                }
            }

            $post->update($data);

            if (isset($data['tags'])) {
                $post->tags()->sync($data['tags']);
            }

            return $post;
        });
    }

    
    public function logView(Post $post, string $ip, string $userAgent): void
    {
        
        $exists = PageView::where('post_id', $post->id)
            ->where('ip_address', $ip)
            ->where('viewed_at', '>=', now()->subMinutes(15))
            ->exists();

        if (!$exists) {
            PageView::create([
                'post_id' => $post->id,
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'viewed_at' => now(),
            ]);
        }
    }

    
    protected function generateUniqueSlug(string $title, ?int $excludeId = 0): string
    {
        $excludeId = $excludeId ?? 0;
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (Post::where('slug', $slug)->where('id', '!=', $excludeId)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
