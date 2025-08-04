<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class AdminArtikelController extends Controller
{
    public function index()
    {
        return view('Backend.artikel.index');
    }

    public function data()
    {
        $artikel = Artikel::select(['id', 'title', 'image', 'is_active', 'created_at']);

        return DataTables::of($artikel)
            ->addColumn('image_display', function ($row) {
                if ($row->image) {
                    return '<img src="' . asset($row->image) . '" alt="Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">';
                }
                return '<span class="text-muted">No Image</span>';
            })
            ->addColumn('status', function ($row) {
                return $row->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>';
            })
            ->addColumn('action', function ($row) {
                return '
                    <div class="btn-group gap-2" role="group">
                        <a href="' .
                    route('admin.artikel.edit', $row->id) .
                    '" class="btn btn-outline-warning btn-sm rounded">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <button type="button" class="btn btn-outline-danger btn-sm rounded btn-delete" onclick="deleteItem(' .
                    $row->id .
                    ')">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </div>
                ';
            })
            ->rawColumns(['image_display', 'status', 'action'])
            ->make(true);
    }

    public function create()
    {
        return view('Backend.artikel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('artikel', $filename, 'public');
            $data['image'] = 'storage/' . $path;
        }

        Artikel::create($data);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Artikel $artikel)
    {
        return view('Backend.artikel.edit', compact('artikel'));
    }

    public function update(Request $request, Artikel $artikel)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($artikel->image && Storage::disk('public')->exists(str_replace('storage/', '', $artikel->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $artikel->image));
            }

            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('artikel', $filename, 'public');
            $data['image'] = 'storage/' . $path;
        }

        $artikel->update($data);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Artikel $artikel)
    {
        // Delete image if exists
        if ($artikel->image && Storage::disk('public')->exists(str_replace('storage/', '', $artikel->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $artikel->image));
        }

        $artikel->delete();

        return response()->json([
            'success' => true,
            'message' => 'Artikel berhasil dihapus.',
        ]);
    }
}
