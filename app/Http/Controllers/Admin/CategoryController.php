<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CategoryController extends Controller
{
    
    public function index()
    {
        if (!Auth::user()->hasPermission('manage-categories')) {
            abort(403);
        }

        $categories = Category::withCount('posts')->orderBy('name', 'asc')->paginate(10);
        return Inertia::render('Admin/Kategori/Index', [
            'categories' => $categories,
        ]);
    }

    
    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('manage-categories')) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string|max:250',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        
        $category = Category::create($validated);

        ActivityLogService::log("Membuat kategori baru: {$category->name}");

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    
    public function update(Request $request, Category $kategori)
    {
        if (!Auth::user()->hasPermission('manage-categories')) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $kategori->id,
            'description' => 'nullable|string|max:250',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        
        $kategori->update($validated);

        ActivityLogService::log("Memperbarui kategori: {$kategori->name}");

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    
    public function destroy(Category $kategori)
    {
        if (!Auth::user()->hasPermission('manage-categories')) {
            abort(403);
        }

        if ($kategori->posts()->count() > 0) {
            return redirect()->route('admin.kategori.index')->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh beberapa artikel.');
        }

        $name = $kategori->name;
        $kategori->delete();

        ActivityLogService::log("Menghapus kategori: {$name}");

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
