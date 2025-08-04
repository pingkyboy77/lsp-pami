<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use App\Models\Sertifikasi;
use App\Models\Stat;
use App\Models\Artikel;
use App\Models\Profile;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\AssociationLogo;
use App\Models\CertificationScheme;

class HomeController extends Controller
{
    public function index()
    {
        $hero = Hero::first(); 
        $stat = Stat::first(); 
        $profile = Profile::first();
        $scheme_items = Sertifikasi::whereNull('parent_id')->where('is_active', true)->orderBy('title')->get();
        $service_items = Service::all();
        $associations = AssociationLogo::all();
        $articles = Artikel::where('is_active', true)->orderByDesc('created_at')->paginate(3);

        return view('page.home.index', compact('hero', 'stat','profile', 'scheme_items', 'service_items', 'associations','articles'));
    }
}
