<?php

namespace App\Http\Controllers\Backend;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Service::latest()->get();
            return DataTables::of($data)
                ->addColumn('icon', function ($item) {
                    return '<img src="' . asset($item->icon ?? 'image/default-icon.svg') . '" width="48" height="48" style="object-fit:cover;">';
                })
                ->addColumn('action', function ($item) {
                    return view('Backend.beranda.services._action', compact('item'))->render();
                })
                ->rawColumns(['icon', 'action'])
                ->make(true);
        }

        return view('Backend.beranda.services.index');
    }

    public function create()
    {
        return view('Backend.beranda.services.create');
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'title' => 'required|string|max:255',
                'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
                'url' => 'nullable|url',
            ]);

            // Prepare data for creation
            $data = $request->only(['title', 'url']);

            // Handle icon upload
            if ($request->hasFile('icon')) {
                $iconPath = $request->file('icon')->store('uploads/services', 'public');
                $data['icon'] = 'storage/' . $iconPath;
            }

            // Create new service
            Service::create($data);

            return redirect()->route('admin.home.services.index')->with('success', 'Service created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to create service: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Service $service)
    {
        return view('Backend.beranda.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        try {
            // Validasi input
            $request->validate([
                'title' => 'required|string|max:255',
                'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
                'url' => 'nullable|url',
            ]);

            // Prepare data for update
            $data = $request->only(['title', 'url']);

            // Handle icon upload
            if ($request->hasFile('icon')) {
                // Delete old icon if exists
                if ($service->icon && Storage::disk('public')->exists(str_replace('storage/', '', $service->icon))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $service->icon));
                }

                // Store new icon
                $iconPath = $request->file('icon')->store('uploads/services', 'public');
                $data['icon'] = 'storage/' . $iconPath;
            }

            // Update service
            $service->update($data);

            return redirect()->route('admin.home.services.index')->with('success', 'Service updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to update service: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Service $service)
    {
        if ($service->icon && Storage::disk('public')->exists(str_replace('storage/', '', $service->icon))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $service->icon));
        }

        $service->delete();

        // return response()->json(['success' => true]);
        return redirect()->route('admin.home.services.index')->with('success', 'Data has been deleted successfully.');
    }
}
