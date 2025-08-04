@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h2 class="modern-title">{{ $title ?? 'Event' }}</h2>
        <hr class="modern-hr">

        {{-- Search Form --}}
        {{-- <div class="row mb-4">
            <div class="col-12">
                <form action="{{ route('informasi.event.search') }}" method="GET">
                    <div class="input-group input-group-lg shadow-sm">
                        <input type="text" name="q" class="form-control shadow-none" placeholder="Cari Event..."
                            value="{{ request('q') }}" required>
                        <button class="btn btn-primary text-light" type="submit">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div> --}}
        <div class="row g-4">
            @forelse ($article_items as $article)
                <div class="col-sm-12 col-md-6 col-lg-3" data-aos="fade-up">
                    <a href="{{ route('informasi.event.show', $article->slug) }}"
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
                                <h5 class="fw-semibold mb-2">{{ $article->title }}</h5>
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
                    <img src="{{ asset('image/berita-kosong.png') }}" alt="Tidak ada event" style="max-width: 300px;"
                        class="mb-3">
                    <p class="text-black">Belum ada event atau berita yang tersedia.</p>
                </div>
            @endforelse
        </div>

        {{-- ✅ PAGINATION SECTION - MENGGUNAKAN BOOTSTRAP-5 --}}
        @if ($article_items->hasPages())
            <div class="d-flex row justify-content-between align-items-center mt-5 pt-4 border-top">
                <div class="custom-pagination">
                    {{ $article_items->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        /* Hide default "Showing X to Y of Z results" dari Bootstrap pagination */
        .custom-pagination .d-none.flex-sm-fill.d-sm-flex.align-items-sm-center.justify-content-sm-between {
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        /* Animasi garis biru maju di card */
        .card.hover-shadow {
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .card.hover-shadow:hover {
            transform: translateY(-5px);
        }

        .card.hover-shadow::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            /* background: #0d6efd; */
            transition: left 0.4s ease;
            z-index: 10;
        }

        .card.hover-shadow:hover::before {
            left: 0;
        }
    </style>
@endpush
