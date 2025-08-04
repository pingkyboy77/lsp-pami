<?php

namespace App\Http\Controllers\Backend;

use App\Models\Footer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FooterController extends Controller
{
    public function index()
    {
        $footer = Footer::first();

        if (!$footer) {
            $footer = Footer::create(); // Isi kosong/default
        }

        // Decode JSON agar bisa digunakan di Blade
        if ($footer->socials && is_string($footer->socials)) {
            $footer->socials = json_decode($footer->socials, true);
        }

        if ($footer->certification_links && is_string($footer->certification_links)) {
            $footer->certification_links = json_decode($footer->certification_links, true);
        }

        return view('Backend.footer.index', compact('footer'));
    }

    public function update(Request $request)
    {
        $request->validate(
            [
                'logo' => 'nullable|image|max:2048',
                'description' => 'nullable|string',
                'map_embed' => 'nullable|string',
                'address' => 'nullable|string',
                'phone' => 'nullable|string',
                'email' => 'nullable|email',
                'city' => 'nullable|string',
                'socials' => 'nullable|array',
                'certification_title' => 'nullable|string',
                'certification_links' => 'nullable|array',
                'subscription_title' => 'nullable|string',
                'subscription_text' => 'nullable|string',
                'subscription_button' => 'nullable|string',
                'subscription_url' => 'nullable|url',
            ],
            [
                'logo.max' => 'Logo must not exceed 2MB.',
            ]
        );

        $footer = Footer::first();

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($footer->logo && Storage::disk('public')->exists(str_replace('storage/', '', $footer->logo))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $footer->logo));
            }

            $path = $request->file('logo')->store('footer', 'public');
            $footer->logo = 'storage/' . $path;
        }

        $footer->fill($request->except(['logo', 'socials', 'certification_links']));
        $footer->socials = json_encode($request->socials);
        $footer->certification_links = json_encode($request->certification_links);
        $footer->save();

        return redirect()->back()->with('success', 'Footer berhasil diperbarui.');
    }
}
