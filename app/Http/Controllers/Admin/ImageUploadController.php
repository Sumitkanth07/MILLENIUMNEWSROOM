<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaItem;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['file' => ['required', 'image', 'max:4096']]);
        $file = $request->file('file');
        $path = $file->store('uploads/editor', 'public');

        MediaItem::create([
            'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'path' => $path,
            'folder' => 'editor',
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'alt_text' => $request->input('alt_text'),
            'user_id' => $request->user()?->id,
        ]);

        return response()->json([
            'location' => asset('storage/'.$path),
            'path' => $path,
            'message' => 'Image uploaded successfully.',
        ]);
    }
}
