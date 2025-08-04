<?php

namespace App\Http\Controllers\Backend;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class AdminEventController extends Controller
{
    public function index()
    {
        return view('Backend.event.index');
    }

    public function data()
    {
        $event = Event::select(['id', 'title', 'image', 'url' ,'is_active', 'created_at']);

        return DataTables::of($event)
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
                    route('admin.event.edit', $row->id) .
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
        return view('Backend.event.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url' => 'required|string|max:255',
            'content' => 'required',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('event', $filename, 'public');
            $data['image'] = 'storage/' . $path;
        }

        Event::create($data);

        return redirect()->route('admin.event.index')->with('success', 'Event berhasil ditambahkan.');
    }

    public function edit(Event $event)
    {
        return view('Backend.event.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
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
            if ($event->image && Storage::disk('public')->exists(str_replace('storage/', '', $event->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $event->image));
            }

            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('event', $filename, 'public');
            $data['image'] = 'storage/' . $path;
        }

        $event->update($data);

        return redirect()->route('admin.event.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        // Delete image if exists
        if ($event->image && Storage::disk('public')->exists(str_replace('storage/', '', $event->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $event->image));
        }

        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event berhasil dihapus.',
        ]);
    }
}
