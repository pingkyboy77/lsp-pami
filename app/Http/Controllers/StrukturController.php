<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StrukturOrganisasi;

class StrukturController extends Controller
{
    public function index()
    {
        $data = StrukturOrganisasi::first();

        return view('page.struktur.index', [
            'title' => $data->title ?? 'Struktur Organisasi LSP - PAMI',
            'struktur_images' => $data->images ?? [],
        ]);
    }

}
