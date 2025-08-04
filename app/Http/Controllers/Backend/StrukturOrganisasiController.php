<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StrukturOrganisasi;
use Illuminate\Support\Facades\Storage;

class StrukturOrganisasiController extends Controller
{
    public function index()
    {
        // Get existing record or create one with default title and empty image array
        $data = StrukturOrganisasi::firstOrCreate(
            [],
            [
                'title' => 'Organizational Structure - LSP PAMI',
                'images' => [],
            ],
        );

        return view('Backend.struktur.index', [
            'title' => $data->title,
            'struktur_images' => $data->images ?? [],
        ]);
    }

    public function updateTitle(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $data = StrukturOrganisasi::first();
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
        $path = $request->file('image')->store('uploads/struktur', 'public');

        $newImage = [
            'path' => 'storage/' . $path,
            'alt' => $request->alt ?? null,
        ];

        // Append to existing image array
        $data = StrukturOrganisasi::first();
        $images = $data->images ?? [];
        $images[] = $newImage;

        $data->update([
            'images' => $images,
        ]);

        return back()->with('success', 'Image has been added.');
    }

    public function deleteImage($index)
    {
        $data = StrukturOrganisasi::first();
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
