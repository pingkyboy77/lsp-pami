<?php

namespace App\Http\Controllers\Backend;

use Exception;
use Illuminate\Support\Str;
use App\Models\SambutanPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SambutanPageController extends Controller
{
    public function index()
    {
        // Retrieve the first Sambutan or create a new one if it doesn't exist
        $sambutan = SambutanPage::first() ?? SambutanPage::create();

        // Return the view and pass the sambutan data to it
        return view('Backend.sambutan.index', compact('sambutan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'page_title' => 'nullable|string|max:255',
            'pengarah_name' => 'nullable|string|max:255',
            'pengarah_title' => 'nullable|string|max:255',
            'pengarah_image' => 'nullable|image|max:2048',
            'pengarah_content' => 'nullable|string',
            'pelaksana_name' => 'nullable|string|max:255',
            'pelaksana_title' => 'nullable|string|max:255',
            'pelaksana_image' => 'nullable|image|max:2048',
            'pelaksana_content' => 'nullable|string',
        ]);

        $sambutan = SambutanPage::findOrFail($id);

        try {
            DB::beginTransaction();

            // Handle Pengarah image
            if ($request->hasFile('pengarah_image')) {
                if ($sambutan->pengarah_image && Storage::disk('public')->exists($sambutan->pengarah_image)) {
                    Storage::disk('public')->delete($sambutan->pengarah_image);
                }
                $pengarahPath = $request->file('pengarah_image')->store('sambutan', 'public');
                $sambutan->pengarah_image = $pengarahPath;
            }

            // Handle Pelaksana image
            if ($request->hasFile('pelaksana_image')) {
                if ($sambutan->pelaksana_image && Storage::disk('public')->exists($sambutan->pelaksana_image)) {
                    Storage::disk('public')->delete($sambutan->pelaksana_image);
                }
                $pelaksanaPath = $request->file('pelaksana_image')->store('sambutan', 'public');
                $sambutan->pelaksana_image = $pelaksanaPath;
            }

            // Update other fields
            $sambutan->update([
                'page_title' => $request->page_title,
                'pengarah_name' => $request->pengarah_name,
                'pengarah_title' => $request->pengarah_title,
                'pengarah_content' => $request->pengarah_content,
                'pelaksana_name' => $request->pelaksana_name,
                'pelaksana_title' => $request->pelaksana_title,
                'pelaksana_content' => $request->pelaksana_content,
                'is_active' => $request->has('is_active') ? 1 : 0,
            ]);

            DB::commit();

            return redirect()->route('admin.sambutan.index')->with('success', 'Sambutan berhasil diperbarui.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal memperbarui sambutan: ' . $e->getMessage()]);
        }
    }
}
