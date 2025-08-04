<?php

namespace App\Http\Controllers;

use App\Models\Sertifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SertifikasiController extends Controller
{
    /**
     * Display a listing of certification categories (parent certifications only)
     */
    public function index()
    {
        $parentSertifikasi = Sertifikasi::whereNull('parent_id')
            ->where('is_active', true)
            ->with(['children' => function($query) {
                $query->where('is_active', true)->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();

        return view('page.sertifikasi.index', compact('parentSertifikasi'));
    }

    /**
     * Display the specified certification (both parent and child)
     */
    public function show($slug)
    {
        $sertifikasi = Sertifikasi::where('slug', $slug)
            ->where('is_active', true)
            ->with([
                'parent',
                'children' => function($query) {
                    $query->where('is_active', true)->orderBy('sort_order');
                },
                'unitKompetensi',
                'persyaratanDasar',
                'biayaUjiKompetensi'
            ])
            ->firstOrFail();

        // If this is a parent certification, show category view with children
        if (!$sertifikasi->parent_id) {
            return view('page.sertifikasi.category', compact('sertifikasi'));
        }

        // If this is a child certification, show detailed view
        return view('page.sertifikasi.show', compact('sertifikasi'));
    }

    /**
     * Get certification image URL with fallback
     */
    public function getImageUrl($certification)
    {
        if ($certification->image && Storage::disk('public')->exists($certification->image)) {
            return Storage::url($certification->image);
        }
        
        return asset('images/certification-placeholder.jpg');
    }

    /**
     * Get active children count for a parent certification
     */
    public function getActiveChildrenCount($certification)
    {
        return $certification->children->where('is_active', true)->count();
    }
}