<?php

namespace App\Http\Controllers\Backend;

use App\Models\ProfileLsp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProfileLspController extends Controller
{
    public function index()
    {
        $profile = ProfileLsp::first();

        if (!$profile) {
            $profile = ProfileLsp::create([
                'title' => 'Profil LSP',
                'content' => '',
                'image' => null,
            ]);
        }

        return view('Backend.profileLsp.index', compact('profile'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'nullable',
            'image' => 'nullable|image|max:2048',
        ]);

        $profile = ProfileLsp::findOrFail($id);

        $data = $request->only('title', 'content');

        if ($request->hasFile('image')) {
            if ($profile->image && Storage::disk('public')->exists(str_replace('storage/', '', $profile->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $profile->image));
            }

            $path = $request->file('image')->store('profileLsp', 'public');
            $profile->image = 'storage/' . $path;
        }

        $profile->update($data);

        return redirect()->route('admin.LspProfile.index')->with('success', 'Profile Lsp updated successfully!');
    }
}
