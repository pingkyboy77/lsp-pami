<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManajemenPenggunaController extends Controller
{
    public function index()
    {

        return view('page.manajemen-pengguna.index');
    }
}
