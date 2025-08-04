<?php

namespace App\Http\Controllers;

use App\Models\SambutanPage;
use Illuminate\Http\Request;

class SambutanController extends Controller
{
    public function index()
    {
        $sambutan = SambutanPage::first();

        return view('page.sambutan.index', compact('sambutan'));
    }
}
