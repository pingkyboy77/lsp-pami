<?php

namespace App\Http\Controllers\Backend;

use App\Models\ParalelPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ParalelPageController extends Controller
{
    public function edit($slug)
    {
        $page = ParalelPage::firstOrCreate(
            ['slug' => $slug],
            [
                'title' => ucwords(str_replace('-', ' ', $slug)),
                'content' => null,
                'banner' => null,
                'is_active' => true,
            ],
        );

        return view('backend.paralel.edit', compact('page'));
    }

    public function update(Request $request, $slug)
    {
        $page = ParalelPage::where('slug', $slug)->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'banner' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('banner')) {
            // Delete old banner
            if ($page->banner && Storage::disk('public')->exists($page->banner)) {
                Storage::disk('public')->delete($page->banner);
            }

            // Save new banner
            $path = $request->file('banner')->store('paralel-page', 'public');
            $page->banner = $path;
        }

        $page->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Halaman berhasil diperbarui.');
    }
}
