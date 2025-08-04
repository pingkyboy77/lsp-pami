<?php

namespace App\Http\Controllers;

use App\Models\Lembaga;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LembagaController extends Controller
{
    /**
     * Display a listing of active lembaga pelatihan.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            // Get all active lembaga ordered by sort order and creation date
            $lembaga_items = Lembaga::active()->ordered()->get();

            // Add meta data for SEO if needed
            $meta = [
                'title' => 'Lembaga Pelatihan - LSP-PM',
                'description' => 'Daftar lembaga pelatihan yang bekerja sama dengan LSP-PM',
                'keywords' => 'lembaga pelatihan, training center, sertifikasi',
            ];

            return view('page.lembaga.index', compact('lembaga_items', 'meta'));
        } catch (\Exception $e) {
            // Log error for debugging
            \Log::error('Error loading lembaga index: ' . $e->getMessage());

            // Return view with empty data
            $lembaga_items = collect();
            return view('page.lembaga.index', compact('lembaga_items'))->with('error', 'Terjadi kesalahan saat memuat data lembaga pelatihan.');
        }
    }

    /**
     * Display the specified lembaga pelatihan.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        try {
            // Find lembaga by slug and ensure it's active
            $lembaga = Lembaga::where('slug', $slug)->where('is_active', true)->firstOrFail();

            // Add meta data for SEO
            $meta = [
                'title' => $lembaga->title . ' - LSP-PM',
                'description' => strip_tags(substr($lembaga->content, 0, 160)) . '...',
                'keywords' => $lembaga->title . ', lembaga pelatihan, training center',
            ];

            // Get related lembaga (exclude current one)
            $related_lembaga = Lembaga::active()->where('id', '!=', $lembaga->id)->ordered()->limit(3)->get();

            return view('page.lembaga.show', compact('lembaga', 'related_lembaga', 'meta'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle 404 cases
            abort(404, 'Lembaga pelatihan tidak ditemukan atau tidak aktif.');
        } catch (\Exception $e) {
            // Log error for debugging
            \Log::error('Error loading lembaga detail: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->route('page.lembaga.index')->with('error', 'Terjadi kesalahan saat memuat detail lembaga pelatihan.');
        }
    }

    /**
     * Search lembaga pelatihan (if needed for future enhancement).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        try {
            $query = $request->get('q', '');

            if (empty($query)) {
                return redirect()->route('lembaga.index');
            }

            // Search in title and content
            $lembaga_items = Lembaga::active()
                ->where(function ($q) use ($query) {
                    $q->whereRaw('LOWER(title) LIKE ?', ['%' . strtolower($query) . '%'])->orWhereRaw('LOWER(content) LIKE ?', ['%' . strtolower($query) . '%']);
                })

                ->ordered()
                ->get();

            $meta = [
                'title' => 'Pencarian: ' . $query . ' - Lembaga Pelatihan',
                'description' => 'Hasil pencarian lembaga pelatihan untuk: ' . $query,
            ];

            return view('page.lembaga.search', compact('lembaga_items', 'query', 'meta'));
        } catch (\Exception $e) {
            \Log::error('Error searching lembaga: ' . $e->getMessage());

            return redirect()->route('lembaga.index')->with('error', 'Terjadi kesalahan saat melakukan pencarian.');
        }
    }

    /**
     * Get sitemap data for lembaga (if needed for SEO).
     *
     * @return array
     */
    public function getSitemapData()
    {
        try {
            return Lembaga::active()
                ->select(['slug', 'updated_at'])
                ->get()
                ->map(function ($lembaga) {
                    return [
                        'url' => route('lembaga.show', $lembaga->slug),
                        'lastmod' => $lembaga->updated_at->format('Y-m-d'),
                        'changefreq' => 'monthly',
                        'priority' => '0.8',
                    ];
                })
                ->toArray();
        } catch (\Exception $e) {
            \Log::error('Error getting lembaga sitemap data: ' . $e->getMessage());
            return [];
        }
    }
}
