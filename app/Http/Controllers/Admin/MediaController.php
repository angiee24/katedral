<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Services\MediaService;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MediaController extends Controller
{
    protected MediaService $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermission('manage-media')) {
            abort(403);
        }

        $query = Media::orderBy('created_at', 'desc');

        if ($request->filled('q')) {
            $query->where('filename', 'like', "%{$request->input('q')}%");
        }

        
        if ($request->wantsJson() || $request->has('json')) {
            $media = $query->get();
            return response()->json($media);
        }

        $mediaFiles = $query->paginate(18);

        return Inertia::render('Admin/Media/Index', [
            'mediaFiles' => $mediaFiles,
            'filters' => $request->only(['q']),
        ]);
    }

    
    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('manage-media')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048', 
        ]);

        if ($request->hasFile('file')) {
            $media = $this->mediaService->upload($request->file('file'), Auth::id());
            ActivityLogService::log("Mengunggah gambar: {$media->filename}");

            if ($request->expectsJson() || $request->has('json')) {
                return response()->json($media, 201);
            }

            return redirect()->back()->with('success', 'Gambar berhasil diunggah.');
        }

        return response()->json(['error' => 'File tidak ditemukan'], 400);
    }

    
    public function destroy(Media $media)
    {
        if (!Auth::user()->hasPermission('manage-media')) {
            abort(403);
        }

        
        if ($media->posts()->exists()) {
            if (request()->expectsJson()) {
                return response()->json(['error' => 'Gambar masih digunakan oleh artikel.'], 422);
            }
            return redirect()->back()->with('error', 'Gambar tidak dapat dihapus karena masih digunakan sebagai gambar sampul artikel.');
        }

        $filename = $media->filename;
        $this->mediaService->delete($media);

        ActivityLogService::log("Menghapus media: {$filename}");

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Media berhasil dihapus.');
    }
}
