<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Lembaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class AdminLembagaController extends Controller
{
    public function index()
    {
        return view('Backend.lembaga.index');
    }

    public function data()
    {
        $lembaga = Lembaga::select(['id', 'title', 'image', 'order', 'is_active', 'created_at']);

        return DataTables::of($lembaga)
            ->addColumn('image_display', function ($row) {
                if ($row->image) {
                    return '<img src="' . asset($row->image) . '" alt="Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">';
                }
                return '<span class="text-muted">No Image</span>';
            })
            ->addColumn('status', function ($row) {
                return $row->is_active 
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-secondary">Inactive</span>';
            })
            ->addColumn('action', function ($row) {
                return '
                    <div class="btn-group gap-2" role="group">
                        <a href="' . route('admin.lembaga.edit', $row->id) . '" class="btn btn-outline-warning btn-sm rounded">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <button type="button" class="btn btn-outline-danger btn-sm rounded btn-delete" onclick="deleteItem(' . $row->id . ')">
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
        return view('Backend.lembaga.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('lembaga', $filename, 'public');
            $data['image'] = 'storage/' . $path;
        }

        Lembaga::create($data);

        return redirect()->route('admin.lembaga.index')
            ->with('success', 'Lembaga berhasil ditambahkan.');
    }

    public function edit(Lembaga $lembaga)
    {
        return view('Backend.lembaga.edit', compact('lembaga'));
    }

    public function update(Request $request, Lembaga $lembaga)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($lembaga->image && Storage::disk('public')->exists(str_replace('storage/', '', $lembaga->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $lembaga->image));
            }

            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('lembaga', $filename, 'public');
            $data['image'] = 'storage/' . $path;
        }

        $lembaga->update($data);

        return redirect()->route('admin.lembaga.index')
            ->with('success', 'Lembaga berhasil diperbarui.');
    }

    public function destroy(Lembaga $lembaga)
    {
        // Delete image if exists
        if ($lembaga->image && Storage::disk('public')->exists(str_replace('storage/', '', $lembaga->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $lembaga->image));
        }

        $lembaga->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lembaga berhasil dihapus.'
        ]);
    }
}
