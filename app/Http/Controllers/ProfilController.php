<?php

namespace App\Http\Controllers;

use App\Models\ProfileLsp;
use Illuminate\Http\Request;
use App\Models\ProfileSection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\LisensiController;

class ProfilController extends Controller
{
    public function index()
    {
        try {
            // Get main profile data
            $main_section = ProfileLsp::first();

            // Get all sections ordered by 'order' column
            $sections = ProfileSection::orderBy('order', 'asc')->get();

            // Debug: Check what we're getting
            \Log::info('Sections data:', ['sections' => $sections]);

            // Ensure $sections is always a Collection
            if (!$sections) {
                $sections = collect();
            }

            return view('page.profil.index', compact('main_section', 'sections'));
        } catch (\Exception $e) {
            Log::error('Error loading profile page: ' . $e->getMessage());
            Log::error('Error trace: ' . $e->getTraceAsString());

            // Fallback data if database fails - ensure Collection
            $main_section = null;
            $sections = collect(); // This creates an empty Collection

            return view('page.profil.index', compact('main_section', 'sections'))->with('error', 'Gagal memuat data profil. Silakan coba lagi nanti.');
        }
    }
}
