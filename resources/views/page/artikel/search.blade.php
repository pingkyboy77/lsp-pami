@extends('layouts.app')

@section('title', $meta['title'] ?? 'Hasil Pencarian Artikel')
@section('meta_description', $meta['description'] ?? '')

@section('content')
    <div class="container py-5">
        <h2 class="modern-title">Hasil Pencarian Artikel</h2>
        <hr class="modern-hr">


        {{-- Search Form --}}
        <div class="row mb-4">
            <div class="col-12">
                <form action="{{ route('informasi.artikel.search') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control form-control-lg shadow-none"
                            placeholder="Cari artikel pelatihan..." value="{{ $query }}" required>
                        <button class="btn btn-primary btn-lg text-light" type="submit">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Results --}}
        <p class="text-center text-muted mb-4">
            Menampilkan hasil pencarian untuk: <strong>"{{ $query }}"</strong>
            ({{ $artikel_items->count() }} hasil ditemukan)
        </p>
        <div class="row g-4">
            @forelse ($artikel_items as $article)
                <div class="col-sm-12 col-md-6 col-lg-4" data-aos="fade-up">
                    <a href="{{ route('informasi.artikel.show', $article->slug) }}"
                        class="text-decoration-none text-dark h-100 d-block">
                        <div class="card border-0 shadow-sm rounded-4 h-100 hover-shadow">
                            @if ($article->image && file_exists(public_path($article->image)))
                                <img src="{{ asset($article->image) }}" alt="{{ $article->title }}"
                                    class="card-img-top img-fluid rounded-top" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center rounded-top"
                                    style="height: 200px;">
                                    <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                </div>
                            @endif

                            <div class="card-body d-flex flex-column">
                                <small class="text-muted mb-1"><i class="bi bi-clock"></i>
                                    {{ \Carbon\Carbon::parse($article->created_at)->translatedFormat('l, d F Y H:i') }}
                                </small>
                                <h5 class="fw-semibold mb-2">{{ $article->title }}</h5>
                                <p class="text-muted small flex-grow-1">
                                    {{ Str::limit(strip_tags($article->content), 100) }}
                                </p>
                            </div>

                            <div class="card-footer bg-transparent border-0">
                                <span class="text-primary small fw-medium">
                                    Baca selengkapnya <i class="bi bi-arrow-right"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center" data-aos="fade-up">
                    <div class="py-5">
                        <i class="bi bi-search text-muted" style="font-size: 4rem;"></i>
                        <h4 class="mt-3 text-muted">Tidak Ada Hasil Ditemukan</h4>
                        <p class="text-muted">
                            Maaf, tidak ada artikel pelatihan yang cocok dengan pencarian Anda.
                        </p>
                        <a href="{{ route('informasi.artikel') }}" class="btn btn-primary mt-3 text-light">
                            <i class="bi bi-arrow-left mx-1"></i> Lihat Semua Artikel
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        @if ($artikel_items->count() > 0)
            <div class="text-center mt-5">
                <a href="{{ route('informasi.artikel') }}" class="btn btn-outline-primary btn-lg ">
                    <i class="bi bi-arrow-left mx-1"></i> Lihat Semua Artikel
                </a>
            </div>
        @endif
    </div>
@endsection
