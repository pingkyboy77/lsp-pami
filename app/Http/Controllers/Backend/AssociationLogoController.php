<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\AssociationLogo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class AssociationLogoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = AssociationLogo::query();
            return DataTables::of($query)
                ->addColumn('image', fn($row) => '<img src="' . asset($row->image) . '" height="40">')
                ->addColumn('action', fn($row) => view('Backend.beranda.association._action', compact('row')))
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        return view('Backend.beranda.association.index');
    }

    public function create()
    {
        return view('Backend.beranda.association.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable|string|max:255',
            'image' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/associations', 'public');
            $data['image'] = 'storage/' . $path;
        }

        AssociationLogo::create($data);
        return redirect()->route('admin.home.associations.index')->with('success', 'Association logo added.');
    }

    public function edit(AssociationLogo $association)
    {
        return view('Backend.beranda.association.edit', compact('association'));
    }

    public function update(Request $request, AssociationLogo $association)
    {
        $data = $request->validate([
            'name' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($association->image && Storage::disk('public')->exists(str_replace('storage/', '', $association->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $association->image));
            }
            $path = $request->file('image')->store('uploads/associations', 'public');
            $data['image'] = 'storage/' . $path;
        }

        $association->update($data);
        return redirect()->route('admin.home.associations.index')->with('success', 'Association logo updated.');
    }

    public function destroy(AssociationLogo $association)
{
    if ($association->image && Storage::disk('public')->exists($association->image)) {
        Storage::disk('public')->delete($association->image);
    }

    $association->delete();

    return redirect()
        ->route('admin.association.index')
        ->with('success', 'Association logo has been deleted successfully.');
}

}
