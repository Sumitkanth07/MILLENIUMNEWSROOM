<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['file' => ['required', 'image', 'max:4096']]);
        $path = $request->file('file')->store('uploads', 'public');

        return response()->json([
            'location' => asset('storage/'.$path),
            'path' => $path,
            'message' => 'Image uploaded successfully.',
        ]);
    }
}
