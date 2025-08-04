@extends('layouts.app')

@section('title', $meta['title'] ?? 'Pencarian Lembaga Pelatihan')
@section('meta_description', $meta['description'] ?? '')

@section('content')
    <div class="container py-5">
        <h2 class="modern-title">Hasil Pencarian Lembaga Pelatihan</h2>
        <hr class="modern-hr">
        

        {{-- Search Form --}}
        <div class="row mb-4">
            <div class="col-12">
                <form action="{{ route('informasi.lembaga.search') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control form-control-lg shadow-none"
                            placeholder="Cari lembaga pelatihan..." value="{{ $query }}" required>
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
            ({{ $lembaga_items->count() }} hasil ditemukan)
        </p>
        <div class="row g-4">
            @forelse ($lembaga_items as $lembaga)
                <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up">
                    <a href="{{ route('informasi.lembaga.show', $lembaga->slug) }}" class="text-decoration-none text-reset">
                        <div class="custom-card">
                            @if ($lembaga->image && file_exists(public_path($lembaga->image)))
                                <img src="{{ asset($lembaga->image) }}" alt="{{ $lembaga->title }}" class="card-img-top">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-secondary text-white"
                                    style="height: 160px;">
                                    <i class="bi bi-building fa-2x opacity-75"></i>
                                </div>
                            @endif

                            <div class="card-footer-custom">
                                <h6>{{ $lembaga->title }}</h6>
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
                            Maaf, tidak ada lembaga pelatihan yang cocok dengan pencarian Anda.
                        </p>
                        <a href="{{ route('informasi.lembaga.index') }}" class="btn btn-primary mt-3">
                            <i class="bi bi-arrow-left"></i> Lihat Semua Lembaga
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        @if ($lembaga_items->count() > 0)
            <div class="text-center mt-5">
                <a href="{{ route('informasi.lembaga.index') }}" class="btn btn-outline-primary btn-lg">
                    <i class="bi bi-arrow-left"></i> Lihat Semua Lembaga Pelatihan
                </a>
            </div>
        @endif
    </div>
@endsection
