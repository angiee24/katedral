<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    
    public function __invoke()
    {
        $bannerTitle = Setting::get('banner_title', 'Selamat Datang di Portal Gereja Katedral Samarinda');
        $bannerSubtitle = Setting::get('banner_subtitle', 'Situs resmi paroki untuk berbagi warta, memperdalam iman, dan merajut persaudaraan dalam kasih Kristus.');
        $bannerImage = Setting::get('banner_image', 'https://images.unsplash.com/photo-1548625361-155de0c7b57a?q=80&w=1200');

        
        $featuredPost = Post::published()
            ->where('is_featured', true)
            ->with(['category', 'media'])
            ->orderBy('published_at', 'desc')
            ->first() 
            ?? Post::published()
                ->with(['category', 'media'])
                ->orderBy('published_at', 'desc')
                ->first();

        
        $featuredId = $featuredPost ? $featuredPost->id : 0;
        $sidePosts = Post::published()
            ->where('id', '!=', $featuredId)
            ->with(['category', 'media'])
            ->orderBy('published_at', 'desc')
            ->limit(2)
            ->get();

        return Inertia::render('Public/Home', [
            'bannerTitle' => $bannerTitle,
            'bannerSubtitle' => $bannerSubtitle,
            'bannerImage' => $bannerImage,
            'featuredPost' => $featuredPost,
            'sidePosts' => $sidePosts,
        ]);
    }
}
