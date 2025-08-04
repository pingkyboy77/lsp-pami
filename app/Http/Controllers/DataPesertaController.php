<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesertaSertifikat;
use Yajra\DataTables\Facades\DataTables;

class DataPesertaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PesertaSertifikat::all();
            return DataTables::of($data)->addIndexColumn()->make(true);
        }

        return view('page.asesi.index');
    }
}
