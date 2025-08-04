<?php

namespace App\Http\Controllers\Backend;

use App\Models\Asesor;
use Illuminate\Http\Request;
use App\Jobs\ImportAsesorJob;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class AsesorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Asesor::latest();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return view('Backend.asesor._action', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Backend.asesor.index');
    }

    public function create()
    {
        return view('Backend.asesor.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        try {
            Asesor::create($validated);
            return redirect()->route('admin.asesor.index')->with('success', 'Data created successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'Failed to create data');
        }
    }

    public function edit(Asesor $asesor)
    {
        return view('Backend.asesor.edit', compact('asesor'));
    }

    public function update(Request $request, Asesor $asesor)
    {
        $validated = $this->validateData($request);

        try {
            $asesor->update($validated);
            return redirect()->route('admin.asesor.index')->with('success', 'Data updated successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'Failed to update data');
        }
    }

    public function destroy(Asesor $asesor)
    {
        try {
            $asesor->delete();
            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false]);
        }
    }
    public function importForm()
    {
        return view('Backend.asesor.import');
    }
    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
    ]);

    $path = $request->file('file')->store('imports');
    ImportAsesorJob::dispatch($path);

    return back()->with('success', 'Import sedang diproses di background.');
}

    protected function validateData(Request $request)
    {
        return $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_met' => 'required|max:255',
        ]);
    }
}
