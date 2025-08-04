<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Sertifikasi;
use App\Models\UnitKompetensi;
use App\Models\PersyaratanDasar;
use App\Models\BiayaUjiKompetensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AdminSertifikasiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getDataTablesData($request);
        }

        return view('Backend.sertifikasi.index');
    }

    public function create(Request $request)
    {
        $parent_id = $request->get('parent_id');
        $parents = [];

        // Only show parent options when creating a child (sub-sertifikasi)
        if ($parent_id !== 'parent') {
            $parents = Sertifikasi::whereNull('parent_id')->where('is_active', true)->orderBy('title')->get();
        }

        return view('Backend.sertifikasi.create', compact('parents', 'parent_id'));
    }

    public function store(Request $request)
    {
        $this->validateSertifikasi($request);

        DB::beginTransaction();
        try {
            $sertifikasi = $this->createSertifikasi($request);
            $this->createRelatedRecords($sertifikasi);

            DB::commit();
            return redirect()
                ->route('admin.sertifikasi.index')
                ->with('success', "Certification \"{$sertifikasi->title}\" has been successfully added.");
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error storing certification: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to add certification.');
        }
    }

    public function edit(Sertifikasi $sertifikasi)
    {
        $parents = Sertifikasi::whereNull('parent_id')->where('id', '!=', $sertifikasi->id)->where('is_active', true)->orderBy('title')->get();

        return view('Backend.sertifikasi.edit', compact('sertifikasi', 'parents'));
    }

    public function update(Request $request, Sertifikasi $sertifikasi)
    {
        $this->validateSertifikasi($request, $sertifikasi->id);

        DB::beginTransaction();
        try {
            $this->updateSertifikasi($request, $sertifikasi);
            $this->updateRelatedRecords($sertifikasi);

            DB::commit();
            return redirect()
                ->route('admin.sertifikasi.index')
                ->with('success', "Certification \"{$sertifikasi->title}\" has been successfully updated.");
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating certification: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to update certification.');
        }
    }

    public function destroy(Sertifikasi $sertifikasi)
    {
        if ($sertifikasi->children()->count() > 0) {
            return redirect()->route('admin.sertifikasi.index')->with('error', 'Cannot delete certification that has sub-certifications.');
        }

        DB::beginTransaction();
        try {
            $this->deleteImage($sertifikasi->image);
            $title = $sertifikasi->title;
            $sertifikasi->delete();

            DB::commit();
            return redirect()
                ->route('admin.sertifikasi.index')
                ->with('success', "Certification \"{$title}\" has been successfully deleted.");
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error deleting certification: ' . $e->getMessage());
            return redirect()->route('admin.sertifikasi.index')->with('error', 'Failed to delete certification.');
        }
    }

    public function toggleStatus(Sertifikasi $sertifikasi)
    {
        try {
            $sertifikasi->update(['is_active' => !$sertifikasi->is_active]);

            return response()->json([
                'success' => true,
                'message' => 'Certification status has been successfully changed.',
                'is_active' => $sertifikasi->is_active,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error toggling status: ' . $e->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Failed to change status.',
                ],
                500,
            );
        }
    }

    // Unit Kompetensi Methods
    public function unitKompetensi(Sertifikasi $sertifikasi)
    {
        $unit = $sertifikasi->unitKompetensi;
        return view('Backend.sertifikasi.unit-kompetensi', compact('sertifikasi', 'unit'));
    }

    public function updateUnitKompetensi(Request $request, Sertifikasi $sertifikasi)
    {
        $request->validate(['content' => 'nullable|string|max:10000']);

        try {
            $sertifikasi->unitKompetensi()->updateOrCreate(['sertifikasi_id' => $sertifikasi->id], ['content' => $request->content ?? '']);

            return redirect()->back()->with('success', 'Competency unit has been successfully updated.');
        } catch (\Exception $e) {
            \Log::error('Error updating competency unit: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to save competency unit.');
        }
    }

    // Persyaratan Dasar Methods
    public function persyaratanDasar(Sertifikasi $sertifikasi)
    {
        if (!$sertifikasi->parent_id) {
            return redirect()->route('admin.sertifikasi.index')->with('error', 'Basic requirements are only for sub-certifications.');
        }

        $persyaratanDasar = $sertifikasi->persyaratanDasar;
        return view('Backend.sertifikasi.persyaratan-dasar', compact('sertifikasi', 'persyaratanDasar'));
    }

    public function updatePersyaratanDasar(Request $request, Sertifikasi $sertifikasi)
    {
        $request->validate(['content' => 'nullable|string|max:10000']);

        try {
            $sertifikasi->persyaratanDasar()->updateOrCreate(['sertifikasi_id' => $sertifikasi->id], ['content' => $request->content ?? '']);

            return redirect()->back()->with('success', 'Basic requirements have been successfully updated.');
        } catch (\Exception $e) {
            \Log::error('Error updating basic requirements: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to save basic requirements.');
        }
    }

    // Biaya Uji Methods
    public function biayaUji(Sertifikasi $sertifikasi)
    {
        if (!$sertifikasi->parent_id) {
            return redirect()->route('admin.sertifikasi.index')->with('error', 'Biaya uji hanya untuk sub-sertifikasi.');
        }

        $biayaUji = $sertifikasi->biayaUjiKompetensi;
        return view('Backend.sertifikasi.biaya-uji', compact('sertifikasi', 'biayaUji'));
    }

    public function updateBiayaUji(Request $request, Sertifikasi $sertifikasi)
    {
        $request->validate(['content' => 'nullable|string|max:10000']);

        try {
            $sertifikasi->biayaUjiKompetensi()->updateOrCreate(['sertifikasi_id' => $sertifikasi->id], ['content' => $request->content ?? '']);

            return redirect()->back()->with('success', 'Test fees have been successfully updated.');
        } catch (\Exception $e) {
            \Log::error('Error updating test fees: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to save test fees.');
        }
    }

    // Private Helper Methods
    private function getDataTablesData(Request $request)
    {
        $type = $request->get('type', 'all');

        // Filter query based on type
        if ($type === 'parent') {
            $query = Sertifikasi::with(['children'])->whereNull('parent_id');
        } elseif ($type === 'child') {
            $query = Sertifikasi::with(['parent'])->whereNotNull('parent_id');
        } else {
            $query = Sertifikasi::with(['parent', 'children']);
        }

        $query->select(['id', 'title', 'parent_id', 'is_active', 'created_at', 'image']);

        $dataTable = DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('title', fn($row) => $this->formatTitle($row, $type))
            ->editColumn('is_active', fn($row) => $this->formatStatus($row))
            ->editColumn('image', fn($row) => $this->formatImage($row))
            ->editColumn('created_at', fn($row) => $row->created_at->format('d/m/Y H:i'))
            ->rawColumns(['title', 'is_active', 'image']);

        // Add columns based on type
        if ($type === 'parent') {
            $dataTable
                ->editColumn('children_count', fn($row) => $this->formatChildrenCount($row))
                ->addColumn('parent_action', fn($row) => $this->formatParentActions($row))
                ->rawColumns(['title', 'children_count', 'is_active', 'image', 'parent_action']);
        } elseif ($type === 'child') {
            $dataTable
                ->editColumn('parent', fn($row) => $this->formatParent($row))
                ->addColumn('child_action', fn($row) => $this->formatChildActions($row))
                ->rawColumns(['title', 'parent', 'is_active', 'image', 'child_action']);
        } else {
            // Default mixed view (if needed)
            $dataTable
                ->editColumn('parent', fn($row) => $this->formatParent($row))
                ->editColumn('children_count', fn($row) => $this->formatChildrenCount($row))
                ->addColumn('action', fn($row) => $this->formatActions($row))
                ->rawColumns(['title', 'parent', 'children_count', 'is_active', 'image', 'action']);
        }

        return $dataTable->make(true);
    }

    private function formatTitle($row, $type = 'all')
    {
        // No indentation needed when tables are separated
        return '<span class="fw-semibold">' . $row->title . '</span>';
    }

    private function formatParent($row)
    {
        return $row->parent ? '<span class="badge bg-light text-dark border">' . $row->parent->title . '</span>' : '<span class="text-muted">-</span>';
    }

    private function formatChildrenCount($row)
    {
        $count = $row->children->count();
        if ($count > 0) {
            return '<span class="badge bg-info rounded-pill">' . $count . ' sub' . ($count > 1 ? 's' : '') . '</span>';
        }
        return '<span class="text-muted">0</span>';
    }

    private function formatStatus($row)
    {
        $class = $row->is_active ? 'success' : 'danger';
        $text = $row->is_active ? 'Active' : 'Inactive';
        $icon = $row->is_active ? 'fas fa-check' : 'fas fa-times';

        return '<button type="button" class="btn btn-' .
            $class .
            ' btn-sm rounded-pill toggle-status"
                        data-id="' .
            $row->id .
            '" title="Click to toggle status">
                    <i class="' .
            $icon .
            ' me-1"></i>' .
            $text .
            '
                </button>';
    }

    private function formatImage($row)
    {
        if ($row->image && Storage::disk('public')->exists($row->image)) {
            return '<img src="' .
                Storage::url($row->image) .
                '"
                         width="50" height="50"
                         class="rounded shadow-sm border"
                         style="object-fit: cover;"
                         alt="' .
                $row->title .
                '">';
        }

        return '<div class="d-flex align-items-center justify-content-center bg-light rounded border"
                     style="width: 50px; height: 50px;">
                    <i class="fas fa-image text-muted"></i>
                </div>';
    }

    // Parent-specific actions (more comprehensive)
    private function formatParentActions($row)
    {
        $actions = '<div class="parent-actions">';

        $actions .=
            '<a href="' .
            route('admin.sertifikasi.edit', $row->id) .
            '"
                        class="btn btn-outline-warning btn-sm rounded" title="Edit">
                        <i class="fa-solid fa-pen-to-square me-1"></i>Edit
                     </a>';

        $actions .=
            '<button type="button"
                        class="btn btn-outline-danger btn-sm rounded btn-delete"
                        data-id="' .
            $row->id .
            '"
                        data-title="' .
            $row->title .
            '"
                        title="Delete">
                        <i class="fas fa-trash me-1"></i>Delete
                     </button>';

        $actions .= '</div>';

        return $actions;
    }

    // Child-specific actions (more compact)
    private function formatChildActions($row)
    {
        $actions = '<div class="child-actions g-2">';

        $actions .=
            '<a href="' .
            route('admin.sertifikasi.edit', $row->id) .
            '"
                        class="btn btn-outline-warning btn-sm rounded" title="Edit">
                        <i class="fas fa-edit"></i>
                     </a>';

        $actions .=
            '<a href="' .
            route('admin.sertifikasi.unit-kompetensi', $row->id) .
            '"
                        class="btn btn-outline-success btn-sm rounded-pill" title="Competency Unit">
                        <i class="fas fa-list"></i>
                     </a>';

        $actions .=
            '<a href="' .
            route('admin.sertifikasi.persyaratan-dasar', $row->id) .
            '"
                        class="btn btn-outline-primary btn-sm rounded-pill" title="Basic Requirements">
                        <i class="fas fa-file-alt"></i>
                     </a>';

        $actions .=
            '<a href="' .
            route('admin.sertifikasi.biaya-uji', $row->id) .
            '"
                        class="btn btn-outline-info btn-sm rounded-pill" title="Test Fees">
                        <i class="fas fa-money-bill-wave"></i>
                     </a>';

        $actions .=
            '<button type="button"
                        class="btn btn-outline-danger btn-sm rounded btn-delete"
                        data-id="' .
            $row->id .
            '"
                        data-title="' .
            $row->title .
            '"
                        title="Delete">
                        <i class="fas fa-trash"></i>
                     </button>';

        $actions .= '</div>';

        return $actions;
    }

    // Original mixed actions (if needed for backward compatibility)
    private function formatActions($row)
    {
        $actions = '<div class="btn-group" role="group">';

        $actions .= $this->getEditButton($row);

        if ($row->parent_id) {
            $actions .= $this->getChildSpecificButtons($row);
        }

        $actions .= $this->getDeleteButton($row);
        $actions .= '</div>';

        return $actions;
    }

    private function getEditButton($row)
    {
        return '<a href="' .
            route('admin.sertifikasi.edit', $row->id) .
            '"
               class="btn btn-outline-warning btn-sm rounded-pill me-1 mb-1" title="Edit">
                <i class="fa-solid fa-pen-to-square me-1"></i>Edit
            </a>';
    }

    private function getChildSpecificButtons($row)
    {
        $buttons = '';

        $buttons .=
            '<a href="' .
            route('admin.sertifikasi.unit-kompetensi', $row->id) .
            '"
                    class="btn btn-sm btn-outline-success rounded-pill me-1 mb-1" title="Competency Unit">
                    <i class="fas fa-list-ul me-1"></i>Competency Unit
                 </a>';

        $buttons .=
            '<a href="' .
            route('admin.sertifikasi.persyaratan-dasar', $row->id) .
            '"
                    class="btn btn-sm btn-outline-primary rounded-pill me-1 mb-1" title="Basic Requirements">
                    <i class="fas fa-file-alt me-1"></i>Basic Requirements
                 </a>';

        $buttons .=
            '<a href="' .
            route('admin.sertifikasi.biaya-uji', $row->id) .
            '"
                    class="btn btn-sm btn-outline-info rounded-pill me-1 mb-1" title="Test Fees">
                    <i class="fas fa-money-bill-wave me-1"></i>Test Fees
                 </a>';

        return $buttons;
    }

    private function getDeleteButton($row)
    {
        return '<button type="button"
                    class="btn btn-outline-danger btn-sm rounded-pill delete-btn mb-1"
                    data-id="' .
            $row->id .
            '"
                    data-title="' .
            $row->title .
            '"
                    title="Delete">
                <i class="fa-solid fa-trash me-1"></i>Delete
            </button>';
    }

    private function validateSertifikasi(Request $request, $id = null)
    {
        $titleRule = 'required|string|max:255|unique:sertifikasi,title';
        if ($id) {
            $titleRule .= ',' . $id;
        }

        $rules = [
            'title' => $titleRule,
            'description' => 'nullable|string|max:5000',
            'parent_id' => 'nullable|exists:sertifikasi,id',
            'is_active' => 'boolean',
        ];

        // Only validate image for parent certification (without parent_id)
        if (!$request->parent_id) {
            $rules['image'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048';
        }

        $messages = [
            'title.required' => 'Certification title is required.',
            'title.unique' => 'Certification title has already been taken.',
            'title.max' => 'Certification title may not be greater than 255 characters.',
            'description.max' => 'Description may not be greater than 5000 characters.',
            'parent_id.exists' => 'The selected parent certification is invalid.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Image format must be jpg, jpeg, png, or webp.',
            'image.max' => 'Image size may not be greater than 2MB.',
        ];

        $request->validate($rules, $messages);
    }

    private function createSertifikasi(Request $request)
    {
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'slug' => Str::slug($request->title),
            'sort_order' => Sertifikasi::max('sort_order') + 1,
            'is_active' => $request->boolean('is_active', true),
        ];

        // Only handle image for parent sertifikasi
        if ($request->hasFile('image') && !$request->parent_id) {
            $data['image'] = $this->uploadImage($request->file('image'), $request->title);
        }

        return Sertifikasi::create($data);
    }

    private function updateSertifikasi(Request $request, Sertifikasi $sertifikasi)
    {
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'slug' => Str::slug($request->title),
            'is_active' => $request->boolean('is_active', true),
        ];

        // Only handle image for parent sertifikasi
        if ($request->hasFile('image') && !$request->parent_id) {
            $this->deleteImage($sertifikasi->image);
            $data['image'] = $this->uploadImage($request->file('image'), $request->title);
        }

        $sertifikasi->update($data);
    }

    private function uploadImage($image, $title)
    {
        $filename = time() . '_' . Str::slug($title) . '.' . $image->getClientOriginalExtension();
        return $image->storeAs('sertifikasi', $filename, 'public');
    }

    private function deleteImage($imagePath)
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }

    private function createRelatedRecords(Sertifikasi $sertifikasi)
    {
        // Always create unit kompetensi
        UnitKompetensi::create([
            'sertifikasi_id' => $sertifikasi->id,
            'content' => '',
        ]);

        // Only create for child sertifikasi
        if ($sertifikasi->parent_id) {
            PersyaratanDasar::create([
                'sertifikasi_id' => $sertifikasi->id,
                'content' => '',
            ]);

            BiayaUjiKompetensi::create([
                'sertifikasi_id' => $sertifikasi->id,
                'content' => '',
            ]);
        }
    }

    private function updateRelatedRecords(Sertifikasi $sertifikasi)
    {
        // If changed to child, create missing records
        if ($sertifikasi->parent_id) {
            if (!$sertifikasi->persyaratanDasar) {
                PersyaratanDasar::create([
                    'sertifikasi_id' => $sertifikasi->id,
                    'content' => '',
                ]);
            }

            if (!$sertifikasi->biayaUjiKompetensi) {
                BiayaUjiKompetensi::create([
                    'sertifikasi_id' => $sertifikasi->id,
                    'content' => '',
                ]);
            }
        } else {
            // If changed to parent, delete child-specific records
            $sertifikasi->persyaratanDasar?->delete();
            $sertifikasi->biayaUjiKompetensi?->delete();
        }
    }
}
