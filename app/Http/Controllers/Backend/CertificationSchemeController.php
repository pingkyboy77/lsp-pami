<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CertificationScheme;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CertificationSchemeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CertificationScheme::latest()->get();
            return DataTables::of($data)
                ->addColumn('action', function ($item) {
                    return view('Backend.beranda.certification._action', compact('item'))->render();
                })
                ->editColumn('icon', function ($item) {
                    if (Str::startsWith($item->icon, 'storage/')) {
                        return '<img src="' . asset($item->icon) . '" class="img-icon">';
                    } else {
                        return '<i class="' . $item->icon . '"></i>';
                    }
                })
                ->editColumn('description', function ($item) {
                    return Str::limit(strip_tags($item->description), 60);
                })
                ->rawColumns(['action', 'icon'])
                ->make(true);
        }

        return view('Backend.beranda.certification.index');
    }

    public function create()
    {
        return view('Backend.beranda.certification.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'nullable|url|max:500',
            'button' => 'nullable|string|max:100',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // Include url and button fields
            $data = $request->only(['title', 'description', 'url', 'button']);

            // Handle icon upload
            if ($request->hasFile('icon')) {
                $iconPath = $request->file('icon')->store('uploads/schemes', 'public');
                $data['icon'] = 'storage/' . $iconPath;
            }

            // Create certification scheme
            CertificationScheme::create($data);

            DB::commit();
            return redirect()->route('admin.home.certifications.index')->with('success', 'Scheme created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete uploaded file if exists and operation failed
            if (isset($data['icon']) && Storage::disk('public')->exists(str_replace('storage/', '', $data['icon']))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $data['icon']));
            }

            return redirect()
                ->back()
                ->with('error', 'Failed to create scheme: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(CertificationScheme $certification)
    {
        return view('Backend.beranda.certification.edit', compact('certification'));
    }

    public function update(Request $request, CertificationScheme $certification)
    {
        // Validasi - tambahkan url dan button
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'nullable|url|max:500',
            'button' => 'nullable|string|max:100',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // Prepare data for update - include url and button
            $data = $request->only(['title', 'description', 'url', 'button']);
            $oldIcon = $certification->icon;
            $newIconPath = null;

            // Handle icon upload
            if ($request->hasFile('icon')) {
                // Store new icon first
                $iconPath = $request->file('icon')->store('uploads/schemes', 'public');
                $newIconPath = 'storage/' . $iconPath;
                $data['icon'] = $newIconPath;
            }

            // Update the certification scheme
            $certification->update($data);

            // Delete old icon only after successful update
            if ($request->hasFile('icon') && $oldIcon && Storage::disk('public')->exists(str_replace('storage/', '', $oldIcon))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $oldIcon));
            }

            DB::commit();
            return redirect()->route('admin.home.certifications.index')->with('success', 'Certification scheme updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete new uploaded file if exists and operation failed
            if ($newIconPath && Storage::disk('public')->exists(str_replace('storage/', '', $newIconPath))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $newIconPath));
            }

            return redirect()
                ->back()
                ->with('error', 'Failed to update certification scheme: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(CertificationScheme $certification)
    {
        DB::beginTransaction();
        try {
            $iconPath = $certification->icon;

            // Delete the certification scheme from database
            $certification->delete();

            // Delete icon file after successful database deletion
            if ($iconPath && Storage::disk('public')->exists(str_replace('storage/', '', $iconPath))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $iconPath));
            }

            DB::commit();
            return redirect()->route('admin.home.certifications.index')->with('success', 'Scheme deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('admin.home.certifications.index')
                ->with('error', 'Failed to delete scheme: ' . $e->getMessage());
        }
    }
}
