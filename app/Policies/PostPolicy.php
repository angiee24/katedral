<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    
    public function viewAny(?User $user): bool
    {
        return true;
    }

    
    public function view(?User $user, Post $post): bool
    {
        if ($post->status === 'published' && ($post->published_at === null || $post->published_at->isPast())) {
            return true;
        }

        return $user !== null && ($user->hasPermission('manage-posts') || $user->id === $post->user_id);
    }

    
    public function create(User $user): bool
    {
        return $user->hasPermission('manage-posts') || $user->hasRole('author');
    }

    
    public function update(User $user, Post $post): bool
    {
        return $user->hasPermission('manage-posts') || ($user->hasRole('author') && $user->id === $post->user_id);
    }

    
    public function delete(User $user, Post $post): bool
    {
        return $user->hasPermission('manage-posts') || ($user->hasRole('author') && $user->id === $post->user_id);
    }

    
    public function publish(User $user): bool
    {
        return $user->hasPermission('publish-posts');
    }
}
