<?php

namespace App\Http\Controllers;

use App\Models\ParalelPage;
use Illuminate\Http\Request;

class ParalelController extends Controller
{
    public function index($slug)
    {
        $page = ParalelPage::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('page.paralel-page.index', [
            'title' => $page->title,
            'banner' => $page->banner ? 'storage/' . $page->banner : null,
            'content' => $page->content,
        ]);
    }
}
