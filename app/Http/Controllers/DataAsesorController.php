<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DataAsesorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = Asesor::latest();

                return DataTables::of($data)
                    ->addIndexColumn() 
                    ->make(true);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Data gagal dimuat: ' . $e->getMessage()
                ], 500);
            }
        }

        return view('page.asesor.index');
    }
}
