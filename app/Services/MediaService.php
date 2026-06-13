<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
    
    public function upload(UploadedFile $file, int $userId): Media
    {
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $filepath = 'media/' . $filename;
        
        // Cache metadata at the start to prevent stat failed exceptions
        $fileSize = $file->getSize();
        $mimeType = $file->getClientMimeType();
        $originalName = $file->getClientOriginalName();
        
        $stream = fopen($file->getPathname(), 'r');
        Storage::disk('public')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        $url = '/storage/' . $filepath;

        return Media::create([
            'filename' => $originalName,
            'filepath' => $filepath,
            'url' => $url,
            'mime_type' => $mimeType,
            'size' => $fileSize,
            'user_id' => $userId,
        ]);
    }

    
    public function delete(Media $media): bool
    {
        if (Storage::disk('public')->exists($media->filepath)) {
            Storage::disk('public')->delete($media->filepath);
        }

        return (bool) $media->delete();
    }
}
