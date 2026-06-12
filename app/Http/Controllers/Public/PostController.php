<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Services\PostService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    
    public function index(Request $request)
    {
        $query = Post::published()->with(['category', 'media']);

        
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        
        if ($request->filled('category')) {
            $categorySlug = $request->input('category');
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        $posts = $query->orderBy('published_at', 'desc')->paginate(6)->withQueryString();
        $categories = Category::all();
        $selectedCategory = $request->input('category');

        return Inertia::render('Public/Warta/Index', [
            'posts' => $posts,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'filters' => $request->only(['q', 'category']),
        ]);
    }

    
    public function show(Request $request, string $slug)
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->with(['category', 'media', 'author'])
            ->firstOrFail();

        
        $this->postService->logView($post, $request->ip(), $request->userAgent());

        
        $popularPosts = Post::published()
            ->withCount('pageViews')
            ->orderBy('page_views_count', 'desc')
            ->limit(3)
            ->get();

        
        $categories = Category::withCount(['posts' => function ($q) {
            $q->where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now());
        }])->get();

        return Inertia::render('Public/Warta/Show', [
            'post' => $post,
            'popularPosts' => $popularPosts,
            'categories' => $categories,
        ]);
    }
}
