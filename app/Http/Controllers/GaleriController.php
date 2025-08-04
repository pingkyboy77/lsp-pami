<?php

namespace App\Http\Controllers;

use App\Models\AdminGaleri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index()
    {
        $data = AdminGaleri::first();

        return view('page.galeri.index', [
            'title' => $data->title ?? 'Galeri Kegiatan',
            'galleries' => $data->images ?? [],
        ]);
    }
}
