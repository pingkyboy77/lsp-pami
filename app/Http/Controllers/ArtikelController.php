<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index()
    {
        $articles = Artikel::where('is_active', true)->orderByDesc('created_at')->paginate(12);

        return view('page.artikel.index', [
            'article_items' => $articles,
        ]);
    }

    public function show($slug)
    {
        $artikel = Artikel::where('slug', $slug)->where('is_active', true)->first();

        if (!$artikel) {
            abort(404);
        }

        $recentPosts = Artikel::where('id', '!=', $artikel->id)->where('is_active', true)->orderByDesc('created_at')->take(5)->get();

        return view('page.artikel.detail', compact('artikel', 'recentPosts'));
    }

    public function search(Request $request)
    {
        try {
            $query = $request->get('q', '');
            if (empty($query)) {
                return redirect()->route('informasi.artikel');
            }
            
            // Search in title and content
            $artikel_items = Artikel::active()
                ->where(function ($q) use ($query) {
                    $q->whereRaw('LOWER(title) LIKE ?', ['%' . strtolower($query) . '%'])->orWhereRaw('LOWER(content) LIKE ?', ['%' . strtolower($query) . '%']);
                })
                ->get();
                
            $meta = [
                'title' => 'Pencarian: ' . $query . ' - Artikel Pelatihan',
                'description' => 'Hasil pencarian artikel pelatihan untuk: ' . $query,
            ];

            return view('page.artikel.search', compact('artikel_items', 'query', 'meta'));
        } catch (\Exception $e) {
            \Log::error('Error searching artikel: ' . $e->getMessage());

            return redirect()->route('informasi.artikel')->with('error', 'Terjadi kesalahan saat melakukan pencarian.');
        }
    }

    /**
     * Get sitemap data for artikel (if needed for SEO).
     *
     * @return array
     */
    public function getSitemapData()
    {
        try {
            return Artikel::active()
                ->select(['slug', 'updated_at'])
                ->get()
                ->map(function ($artikel) {
                    return [
                        'url' => route('artikel.show', $artikel->slug),
                        'lastmod' => $artikel->updated_at->format('Y-m-d'),
                        'changefreq' => 'monthly',
                        'priority' => '0.8',
                    ];
                })
                ->toArray();
        } catch (\Exception $e) {
            \Log::error('Error getting artikel sitemap data: ' . $e->getMessage());
            return [];
        }
    }
}
