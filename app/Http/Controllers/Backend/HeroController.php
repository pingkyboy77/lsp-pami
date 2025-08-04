<?php
namespace App\Http\Controllers\Backend;

use App\Models\Hero;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    public function index()
    {
        $hero = Hero::first() ?? Hero::create();
        return view('Backend.beranda.hero.index', compact('hero'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string',
            'highlight' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'cta_1' => 'nullable|array',
            'cta_2' => 'nullable|array',
            'badge' => 'nullable|array',
            'date' => 'nullable|string',
        ], [
            'image.max' => 'Gambar tidak boleh lebih dari 2MB.'
        ]);

        $hero = Hero::first();

        if ($request->hasFile('image')) {
            if ($hero->image && Storage::disk('public')->exists(str_replace('storage/', '', $hero->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $hero->image));
            }

            $path = $request->file('image')->store('hero', 'public');
            $hero->image = 'storage/' . $path;
        }

        $hero->fill($request->except('image'));
        $hero->save();

        return redirect()->back()->with('success', 'Hero berhasil diperbarui.');
    }
}
