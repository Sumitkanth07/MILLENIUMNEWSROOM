<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class BrandingController extends Controller
{
    public function edit()
    {
        return view('admin.branding.edit');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_title' => ['required', 'string', 'max:255'],
            'tagline' => ['required', 'string', 'max:255'],
            'primary_color' => ['required', 'string', 'max:20'],
            'secondary_color' => ['required', 'string', 'max:20'],
            'meta_description' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $uploadedLogo = $request->hasFile('logo');

        if ($uploadedLogo) {
            $data['logo'] = $request->file('logo')->store('uploads', 'public');
        }

        foreach ($data as $key => $value) {
            Setting::setValue($key, $value);
        }

        $message = $uploadedLogo
            ? 'Branding saved and logo uploaded successfully.'
            : 'Branding saved successfully.';

        return back()->with('status', $message);
    }
}
