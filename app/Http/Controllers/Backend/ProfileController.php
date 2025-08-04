<?php

namespace App\Http\Controllers\Backend;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Profile::first() ?? new Profile();
        return view('Backend.beranda.profile.index', compact('profile'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'paragraph_1' => 'nullable|string',
            'paragraph_2' => 'nullable|string',
            'button_text' => 'nullable|string',
            'button_url' => 'nullable|string',
            'card_text' => 'nullable|string',
            'video_url' => 'nullable|string',
        ]);

        $profile = Profile::first();
        if (!$profile) {
            Profile::create($data);
        } else {
            $profile->update($data);
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
