<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSection;
use Illuminate\Http\Request;

class HomepageSectionController extends Controller
{
    public function index()
    {
        return view('admin.homepage.index', ['sections' => HomepageSection::orderBy('sort_order')->get()]);
    }

    public function edit(HomepageSection $homepage)
    {
        return view('admin.homepage.edit', ['section' => $homepage]);
    }

    public function update(Request $request, HomepageSection $homepage)
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $uploadedImage = $request->hasFile('image');

        if ($uploadedImage) {
            $data['image'] = $request->file('image')->store('uploads', 'public');
        }

        $data['is_active'] = $request->boolean('is_active');
        $homepage->update($data);

        $message = $uploadedImage
            ? 'Homepage section saved and image uploaded successfully.'
            : 'Homepage section saved successfully.';

        return redirect()->route('admin.homepage.index')->with('status', $message);
    }
}
