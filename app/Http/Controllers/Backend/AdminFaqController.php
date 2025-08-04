<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Exception;

class AdminFaqController extends Controller
{
    public function index()
    {
        try {
            return view('Backend.faq.index');
        } catch (Exception $e) {
            Log::error('FAQ Index Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat halaman FAQ.');
        }
    }

    public function getData(Request $request)
    {
        try {
            $faqs = Faq::select(['id', 'question', 'answer', 'is_active', 'sort_order', 'created_at']);

            return DataTables::of($faqs)
                ->addIndexColumn()
                ->addColumn('status', function ($faq) {
                    return $faq->is_active 
                        ? '<span class="badge bg-success">Aktif</span>' 
                        : '<span class="badge bg-secondary">Tidak Aktif</span>';
                })
                ->addColumn('answer_preview', function ($faq) {
                    return \Str::limit(strip_tags($faq->answer), 50);
                })
                ->addColumn('action', function ($faq) {
                    return '
                        <div class="btn-group gap-2" role="group">
                            <button type="button" class="btn btn-outline-warning btn-sm rounded" onclick="editFaq(' . $faq->id . ')">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm rounded btn-delete" onclick="deleteFaq(' . $faq->id . ')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        } catch (Exception $e) {
            Log::error('FAQ DataTable Error: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memuat data FAQ'], 500);
        }
    }

    public function create()
    {
        try {
            return view('Backend.faq.create');
        } catch (Exception $e) {
            Log::error('FAQ Create Page Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat form tambah FAQ.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'question' => 'required|string|max:255',
                'answer' => 'required|string',
                'is_active' => 'boolean',
                'sort_order' => 'integer|min:0'
            ]);

            Faq::create([
                'question' => $request->question,
                'answer' => $request->answer,
                'is_active' => $request->has('is_active'),
                'sort_order' => $request->sort_order ?? 0
            ]);

            return response()->json([
                'success' => true,
                'message' => 'FAQ berhasil ditambahkan!'
            ]);
        } catch (Exception $e) {
            Log::error('FAQ Store Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan FAQ. ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $faq = Faq::findOrFail($id);
            return response()->json($faq);
        } catch (Exception $e) {
            Log::error('FAQ Show Error: ' . $e->getMessage());
            return response()->json(['error' => 'FAQ tidak ditemukan'], 404);
        }
    }

    public function edit($id)
    {
        try {
            $faq = Faq::findOrFail($id);
            return view('Backend.faq.edit', compact('faq'));
        } catch (Exception $e) {
            Log::error('FAQ Edit Page Error: ' . $e->getMessage());
            return back()->with('error', 'FAQ tidak ditemukan atau terjadi kesalahan.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $faq = Faq::findOrFail($id);
            
            $request->validate([
                'question' => 'required|string|max:255',
                'answer' => 'required|string',
                'is_active' => 'boolean',
                'sort_order' => 'integer|min:0'
            ]);
            // dd($request->all());
            $faq->update([
                'question' => $request->question,
                'answer' => $request->answer,
                'is_active' =>  (bool) $request->is_active,
                'sort_order' => $request->sort_order ?? 0
            ]);

            return response()->json([
                'success' => true,
                'message' => 'FAQ berhasil diperbarui!'
            ]);
        } catch (Exception $e) {
            Log::error('FAQ Update Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui FAQ. ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $faq = Faq::findOrFail($id);
            $faq->delete();

            return response()->json([
                'success' => true,
                'message' => 'FAQ berhasil dihapus!'
            ]);
        } catch (Exception $e) {
            Log::error('FAQ Delete Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus FAQ. ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus($id)
    {
        try {
            $faq = Faq::findOrFail($id);
            $faq->update(['is_active' => !$faq->is_active]);

            return response()->json([
                'success' => true,
                'message' => 'Status FAQ berhasil diubah!',
                'is_active' => $faq->is_active
            ]);
        } catch (Exception $e) {
            Log::error('FAQ Toggle Status Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status FAQ.'
            ], 500);
        }
    }
}
