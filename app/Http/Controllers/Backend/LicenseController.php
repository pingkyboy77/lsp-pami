<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\License;
use App\Models\LicenseSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LicenseController extends Controller
{
    /**
     * Display license management page
     */
    public function index(Request $request)
    {
        // Get license settings
        $settings = LicenseSetting::getLicenseSettings();
        
        return view('Backend.licenses.index', compact('settings'));
    }

    /**
     * Get data for DataTables
     */
    public function data(Request $request)
    {
        $licenses = License::getAllOrdered();
        
        return DataTables::of($licenses)
            ->addIndexColumn()
            ->addColumn('action', function ($license) {
                return view('Backend.licenses._action', compact('license'))->render();
            })
            ->editColumn('image', function ($license) {
                if ($license->image) {
                    return '<img src="' . asset($license->image) . '" class="img-thumbnail" style="max-width: 80px; max-height: 60px; object-fit: cover;">';
                }
                return '<span class="text-muted">No Image</span>';
            })
            ->editColumn('subtitle', function ($license) {
                return $license->subtitle ?? '-';
            })
            ->editColumn('description_preview', function ($license) {
                $desc = $license->desc1 ?? $license->desc2;
                return $desc ? Str::limit(strip_tags($desc), 50) : '-';
            })
            ->editColumn('status', function ($license) {
                $badgeClass = $license->status === 'active' ? 'bg-success' : 'bg-secondary';
                return '<span class="badge ' . $badgeClass . '">' . ucfirst($license->status) . '</span>';
            })
            ->rawColumns(['action', 'image', 'status'])
            ->make(true);
    }

    /**
     * Update license page settings
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'license_title' => 'required|string|max:255',
            'license_description' => 'required|string',
        ]);

        try {
            DB::transaction(function () use ($request) {
                LicenseSetting::setValue('license_title', $request->license_title, 'text', 'Title for license page');
                LicenseSetting::setValue('license_description', $request->license_description, 'textarea', 'Description for license page');
            });

            return redirect()->route('admin.licenses.index')
                ->with('success', 'License page settings updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update settings: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for creating a new license
     */
    public function create()
    {
        return view('Backend.licenses.create');
    }

    /**
     * Store a newly created license
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'desc1' => 'nullable|string',
            'desc2' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'order' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $data = $request->only(['title', 'subtitle', 'desc1', 'desc2', 'order', 'status']);

                // Handle image upload
                if ($request->hasFile('image')) {
                    $imagePath = $request->file('image')->store('uploads/licenses', 'public');
                    $data['image'] = 'storage/' . $imagePath;
                }

                License::create($data);
            });

            return redirect()->route('admin.licenses.index')
                ->with('success', 'License created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create license: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing license
     */
    public function edit(License $license)
    {
        return view('Backend.licenses.edit', compact('license'));
    }

    /**
     * Update the specified license
     */
    public function update(Request $request, License $license)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'desc1' => 'nullable|string',
            'desc2' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'order' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            DB::transaction(function () use ($request, $license) {
                $data = $request->only(['title', 'subtitle', 'desc1', 'desc2', 'order', 'status']);
                $oldImage = $license->image;

                // Handle image upload
                if ($request->hasFile('image')) {
                    $imagePath = $request->file('image')->store('uploads/licenses', 'public');
                    $data['image'] = 'storage/' . $imagePath;
                }

                // Update license
                $license->update($data);

                // Delete old image if new one uploaded
                if ($request->hasFile('image') && $oldImage) {
                    $oldImagePath = str_replace('storage/', '', $oldImage);
                    if (Storage::disk('public')->exists($oldImagePath)) {
                        Storage::disk('public')->delete($oldImagePath);
                    }
                }
            });

            return redirect()->route('admin.licenses.index')
                ->with('success', 'License updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update license: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified license
     */
    public function destroy(License $license)
    {
        try {
            DB::transaction(function () use ($license) {
                $imagePath = $license->image;

                // Delete license
                $license->delete();

                // Delete image file
                if ($imagePath) {
                    $imageFile = str_replace('storage/', '', $imagePath);
                    if (Storage::disk('public')->exists($imageFile)) {
                        Storage::disk('public')->delete($imageFile);
                    }
                }
            });

            return redirect()->route('admin.licenses.index')
                ->with('success', 'License deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.licenses.index')
                ->with('error', 'Failed to delete license: ' . $e->getMessage());
        }
    }
}