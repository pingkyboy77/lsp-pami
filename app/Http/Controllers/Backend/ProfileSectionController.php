<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProfileSection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProfileSectionController extends Controller
{
    public function index()
    {
        return view('backend.profileLsp.section.index');
    }

    // DataTable server-side processing
    public function getData(Request $request)
    {
        try {
            $sections = ProfileSection::select(['id', 'key', 'title', 'content', 'order'])
                                     ->orderBy('order', 'asc');

            return DataTables::of($sections)
                ->addIndexColumn()
                ->addColumn('key', function ($section) {
                    return '<code class="bg-light p-1 rounded">' . $section->key . '</code>';
                })
                ->addColumn('title', function ($section) {
                    return '<strong>' . $section->title . '</strong>';
                })
                ->addColumn('content_preview', function ($section) {
                    return '<small class="text-muted">' . 
                           Str::limit(strip_tags($section->content), 80) . 
                           '</small>';
                })
                ->addColumn('order', function ($section) {
                    return '<span class="badge bg-info">' . $section->order . '</span>';
                })
                ->addColumn('action', function ($item) {
                    return view('Backend.profileLsp.section._action', compact('item'))->render();
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('search')['value']) {
                        $search = $request->get('search')['value'];
                        $instance->where(function($w) use ($search) {
                            $w->where('key', 'LIKE', "%$search%")
                              ->orWhere('title', 'LIKE', "%$search%")
                              ->orWhere('content', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['key', 'title', 'content_preview', 'order', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            Log::error('Error in ProfileSection getData: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memuat data section'], 500);
        }
    }

    public function create()
    {
        return view('backend.profileLsp.section.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'key' => 'required|string|unique:profile_sections,key',
                'title' => 'required|string|max:255',
                'content' => 'nullable|string',
                'order' => 'nullable|integer'
            ]);

            DB::beginTransaction();

            $data = $request->only(['key', 'title', 'content', 'order']);
            
            // Set default order if not provided
            if (!$data['order']) {
                $data['order'] = ProfileSection::max('order') + 1;
            }

            ProfileSection::create($data);

            DB::commit();

            return redirect()->route('admin.lsp.sections.index')
                            ->with('success', 'Section berhasil ditambahkan.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return redirect()->back()
                            ->withErrors($e->validator)
                            ->withInput();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating ProfileSection: ' . $e->getMessage());
            
            return redirect()->back()
                            ->with('error', 'Gagal menambahkan section. Silakan coba lagi.')
                            ->withInput();
        }
    }

    public function edit($key)
    {
        try {
            $section = ProfileSection::where('key', $key)->firstOrFail();
            return view('backend.profileLsp.section.edit', compact('section'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.lsp.sections.index')
                            ->with('error', 'Section tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error in ProfileSection edit: ' . $e->getMessage());
            return redirect()->route('admin.lsp.sections.index')
                            ->with('error', 'Gagal memuat halaman edit.');
        }
    }

    public function update(Request $request, $key)
    {
        try {
            $section = ProfileSection::where('key', $key)->firstOrFail();
            
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'nullable|string',
                'order' => 'nullable|integer'
            ]);

            DB::beginTransaction();

            $data = $request->only(['title', 'content', 'order']);
            $section->update($data);

            DB::commit();

            return redirect()->route('admin.lsp.sections.index')
                            ->with('success', 'Section berhasil diupdate.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollback();
            return redirect()->route('admin.lsp.sections.index')
                            ->with('error', 'Section tidak ditemukan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return redirect()->back()
                            ->withErrors($e->validator)
                            ->withInput();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating ProfileSection: ' . $e->getMessage());
            
            return redirect()->back()
                            ->with('error', 'Gagal mengupdate section. Silakan coba lagi.')
                            ->withInput();
        }
    }

    public function destroy($key)
    {
        try {
            DB::beginTransaction();

            $section = ProfileSection::where('key', $key)->firstOrFail();
            $section->delete();

            DB::commit();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Section berhasil dihapus.'
                ]);
            }

            return redirect()->route('admin.lsp.sections.index')
                            ->with('success', 'Section berhasil dihapus.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollback();
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Section tidak ditemukan.'
                ], 404);
            }

            return redirect()->route('admin.lsp.sections.index')
                            ->with('error', 'Section tidak ditemukan.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error deleting ProfileSection: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus section.'
                ], 500);
            }

            return redirect()->route('admin.lsp.sections.index')
                            ->with('error', 'Gagal menghapus section.');
        }
    }

    // Method untuk TinyMCE image upload
    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            if (!$request->hasFile('file')) {
                return response()->json(['error' => 'No file uploaded.'], 400);
            }

            DB::beginTransaction();

            $file = $request->file('file');
            $fileName = time() . '_' . \Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('tinymce-uploads', $fileName, 'public');
            
            if (!$path) {
                throw new \Exception('Failed to store file');
            }

            $url = asset('storage/' . $path);

            DB::commit();
            
            return response()->json(['location' => $url]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return response()->json([
                'error' => 'Validation failed: ' . implode(', ', $e->validator->errors()->all())
            ], 422);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error uploading image: ' . $e->getMessage());
            return response()->json(['error' => 'Upload failed: ' . $e->getMessage()], 500);
        }
    }

    // Method untuk reorder sections
    public function reorder(Request $request)
    {
        try {
            $request->validate([
                'sections' => 'required|array',
                'sections.*.key' => 'required|string',
                'sections.*.order' => 'required|integer'
            ]);

            DB::beginTransaction();

            foreach ($request->sections as $sectionData) {
                $section = ProfileSection::where('key', $sectionData['key'])->first();
                
                if (!$section) {
                    throw new \Exception('Section with key ' . $sectionData['key'] . ' not found');
                }
                
                $section->update(['order' => $sectionData['order']]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Urutan section berhasil diupdate.'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return response()->json([
                'success' => false, 
                'message' => 'Validation error: ' . implode(', ', $e->validator->errors()->all())
            ], 422);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error reordering sections: ' . $e->getMessage());
            
            return response()->json([
                'success' => false, 
                'message' => 'Gagal mengupdate urutan section: ' . $e->getMessage()
            ], 500);
        }
    }
}
