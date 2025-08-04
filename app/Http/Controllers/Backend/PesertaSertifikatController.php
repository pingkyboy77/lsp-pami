<?php

namespace App\Http\Controllers\Backend;

use App\Models\Sertifikasi;
use Illuminate\Http\Request;
use App\Models\PesertaSertifikat;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PesertaSertifikatImport;
use App\Jobs\ImportPesertaSertifikatJob;
use Yajra\DataTables\Facades\DataTables;

class PesertaSertifikatController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PesertaSertifikat::latest();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return view('Backend.peserta-sertifikat._action', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Backend.peserta-sertifikat.index');
    }

    public function create()
    {
        return view('Backend.peserta-sertifikat.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        try {
            PesertaSertifikat::create($validated);
            return redirect()->route('admin.peserta-sertifikat.index')->with('success', 'Data created successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'Failed to create data');
        }
    }

    public function edit(PesertaSertifikat $pesertaSertifikat)
    {
        
        return view('Backend.peserta-sertifikat.edit', compact('pesertaSertifikat'));
    }

    public function update(Request $request, PesertaSertifikat $pesertaSertifikat)
    {
        $validated = $this->validateData($request);

        try {
            $pesertaSertifikat->update($validated);
            return redirect()->route('admin.peserta-sertifikat.index')->with('success', 'Data updated successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'Failed to update data');
        }
    }

    public function destroy(PesertaSertifikat $pesertaSertifikat)
    {
        try {
            $pesertaSertifikat->delete();
            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false]);
        }
    }

    public function importForm()
    {
        return view('Backend.peserta-sertifikat.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $path = $request->file('file')->store('imports');
        ImportPesertaSertifikatJob::dispatch($path); // ✅ hanya antri ke queue

        return back()->with('success', 'Import sedang diproses di background.');
    }

    protected function validateData(Request $request)
    {
        return $request->validate([
            'nama' => 'required|string|max:255',
            'sertifikasi_id' => 'required|exists:sertifikasi,id',
            'no_ser' => 'nullable|string|max:255',
            'no_reg' => 'nullable|string|max:255',
            'no_sertifikat' => 'nullable|string|max:255',
            'tanggal_terbit' => 'nullable|date',
            'tanggal_exp' => 'nullable|date',
            'registrasi_nomor' => 'nullable|string|max:255',
            'tahun_registrasi' => 'nullable|string|max:255',
            'nomor_blanko' => 'nullable|string|max:255',
        ]);
    }
}
