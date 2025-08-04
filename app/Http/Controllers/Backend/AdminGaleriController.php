<?php

namespace App\Http\Controllers\Backend;

use App\Models\AdminGaleri;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminGaleriController extends Controller
{
    public function index()
    {
        // Get existing record or create one with default title and empty image array
        $data = AdminGaleri::firstOrCreate(
            [],
            [
                'title' => 'Galeri Kegiatan',
                'images' => [],
            ],
        );

        return view('Backend.galeri.index', [
            'title' => $data->title,
            'galeri_images' => $data->images ?? [],
        ]);
    }

    public function updateTitle(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $data = AdminGaleri::first();
        $data->update([
            'title' => $request->title,
        ]);

        return back()->with('success', 'Title has been updated.');
    }

    public function appendImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'alt' => 'nullable|string|max:255',
        ]);

        // Upload image to storage
        $path = $request->file('image')->store('uploads/Galeri', 'public');

        $newImage = [
            'path' => 'storage/' . $path,
            'alt' => $request->alt ?? null,
        ];

        // Append to existing image array
        $data = AdminGaleri::first();
        $images = $data->images ?? [];
        $images[] = $newImage;

        $data->update([
            'images' => $images,
        ]);

        return back()->with('success', 'Image has been added.');
    }

    public function deleteImage($index)
    {
        $data = AdminGaleri::first();
        $images = $data->images ?? [];

        // Remove the image if index exists
        if (isset($images[$index])) {
            // Delete physical file
            Storage::disk('public')->delete(str_replace('storage/', '', $images[$index]['path']));

            // Remove image data from array
            array_splice($images, $index, 1);

            $data->update(['images' => $images]);
        }

        return back()->with('success', 'Image has been deleted.');
    }
}
