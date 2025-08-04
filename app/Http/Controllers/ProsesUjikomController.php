<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminProsesUjikom;

class ProsesUjikomController extends Controller
{
    public function index()
    {
        $data = AdminProsesUjikom::first();

        return view('page.proses-ujikom.index', [
            'title' => $data->title ?? 'Struktur Organisasi LSP - PAMI',
            'struktur_images' => $data->images ?? [],
        ]);
    }
}
