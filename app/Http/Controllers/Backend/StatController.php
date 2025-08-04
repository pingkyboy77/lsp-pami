<?php

namespace App\Http\Controllers\Backend;

use App\Models\Stat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class StatController extends Controller
{
    public function index()
    {
        $stat = Stat::first() ?? Stat::create(); // default kosong
        return view('backend.beranda.stat.index', compact('stat'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string',
            'map_image' => 'nullable|image|max:2048',
            'items' => 'nullable|array',
            'items.*.label' => 'nullable|string',
            'items.*.count' => 'nullable|string',
        ]);

        $stat = Stat::first();

        if ($request->hasFile('map_image')) {
            if ($stat->map_image && Storage::disk('public')->exists(str_replace('storage/', '', $stat->map_image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $stat->map_image));
            }

            $path = $request->file('map_image')->store('stats', 'public');
            $stat->map_image = 'storage/' . $path;
        }

        $stat->title = $request->title;
        $stat->items = $request->items;
        $stat->save();

        return redirect()->back()->with('success', 'Data statistik berhasil diperbarui.');
    }
}
