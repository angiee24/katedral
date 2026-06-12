<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Media;
use App\Services\PostService;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;

class PostController extends Controller
{
    use AuthorizesRequests;

    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    
    public function index(Request $request)
    {
        $this->authorize('viewAny', Post::class);

        $query = Post::with(['category', 'author', 'media']);

        
        if (!Auth::user()->hasPermission('manage-posts')) {
            $query->where('user_id', Auth::id());
        }

        
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $categories = Category::all();

        return Inertia::render('Admin/Berita/Index', [
            'posts' => $posts,
            'categories' => $categories,
            'filters' => $request->only(['q', 'category', 'status']),
        ]);
    }

    
    public function create()
    {
        $this->authorize('create', Post::class);

        $categories = Category::all();
        $tags = Tag::all();
        $mediaFiles = Media::orderBy('created_at', 'desc')->get();

        return Inertia::render('Admin/Berita/Create', [
            'categories' => $categories,
            'tags' => $tags,
            'mediaFiles' => $mediaFiles,
        ]);
    }

    
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);

        $rules = [
            'title' => 'required|string|max:200',
            'excerpt' => 'nullable|string|max:300',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'media_id' => 'nullable|exists:media,id',
            'status' => 'required|in:draft,published,scheduled',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'is_featured' => 'nullable|boolean',
        ];

        if ($request->input('status') === 'scheduled') {
            $rules['published_at'] = 'required|date|after:now';
        } else {
            $rules['published_at'] = 'nullable|date';
        }

        $validated = $request->validate($rules);
        $validated['is_featured'] = $request->boolean('is_featured');

        
        if ($validated['status'] !== 'draft' && !Auth::user()->hasPermission('publish-posts')) {
            $validated['status'] = 'draft';
            $validated['published_at'] = null;
        }

        $post = $this->postService->createPost($validated, Auth::id());

        ActivityLogService::log("Membuat artikel baru: {$post->title}");

        return redirect()->route('admin.berita.index')->with('success', 'Artikel berhasil dibuat.');
    }

    
    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        $post->load(['tags', 'media']);

        $categories = Category::all();
        $tags = Tag::all();
        $mediaFiles = Media::orderBy('created_at', 'desc')->get();

        return Inertia::render('Admin/Berita/Edit', [
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags,
            'mediaFiles' => $mediaFiles,
        ]);
    }

    
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $rules = [
            'title' => 'required|string|max:200',
            'excerpt' => 'nullable|string|max:300',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'media_id' => 'nullable|exists:media,id',
            'status' => 'required|in:draft,published,scheduled',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'is_featured' => 'nullable|boolean',
        ];

        if ($request->input('status') === 'scheduled') {
            $rules['published_at'] = 'required|date';
        } else {
            $rules['published_at'] = 'nullable|date';
        }

        $validated = $request->validate($rules);
        $validated['is_featured'] = $request->boolean('is_featured');

        
        if ($validated['status'] !== 'draft' && !Auth::user()->hasPermission('publish-posts')) {
            $validated['status'] = 'draft';
            $validated['published_at'] = null;
        }

        $this->postService->updatePost($post, $validated);

        ActivityLogService::log("Memperbarui artikel: {$post->title}");

        return redirect()->route('admin.berita.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $title = $post->title;
        $post->delete();

        ActivityLogService::log("Menghapus artikel: {$title}");

        return redirect()->route('admin.berita.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
