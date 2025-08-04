@extends('layouts.app')

@push('styles')
<style>
    .breadcrumb-wrapper {
        background-color: #f0f4f8;
        padding: 1rem 0;
    }

    .breadcrumb {
        margin: 0;
        font-size: 0.95rem;
        background: none;
        padding: 0;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        padding: 0 0.5rem;
        color: #6c757d;
    }

    .breadcrumb a {
        color: #007bff;
        text-decoration: none;
    }

    .breadcrumb a:hover {
        text-decoration: underline;
    }

    .breadcrumb .active {
        color: #6c757d;
    }

    .content-wrapper img {
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
    }

    .recent-posts a {
        color: #333;
    }

    .recent-posts a:hover {
        color: #007bff;
        text-decoration: underline;
    }

    .btn-back {
        margin-top: 1rem;
    }

    @media (max-width: 768px) {
        .btn-back {
            text-align: left;
            margin-bottom: 1rem;
        }

        .recent-posts {
            padding-top: 1rem;
            border-top: 1px solid #ddd;
        }
    }

    @media (max-width: 991.98px) {
        .sticky-top {
            position: static !important;
            top: auto !important;
        }
    }

    .content-wrapper,
    .recent-posts {
        transition: all 0.3s ease-in-out;
    }
</style>
@endpush

@section('content')
    {{-- Breadcrumb --}}
    <div class="breadcrumb-wrapper">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('informasi.artikel') }}">Artikel</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $artikel['title'] }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container">
        {{-- Konten dan Sidebar --}}
        <div class="row gy-4 mt-3 pb-5">
            {{-- Konten Utama --}}
            <div class="col-lg-8">
                <div class="btn-back mb-3">
                    <a href="{{ route('informasi.artikel') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

                {{-- Gambar --}}
                <img src="{{ asset($artikel['image']) }}" class="img-fluid rounded mb-3" alt="{{ $artikel['title'] }}">

                {{-- Tanggal --}}
                <p class="text-muted mb-1">
                    <i class="bi bi-clock me-2"></i>
                    {{ \Carbon\Carbon::parse($artikel['created_at'])->translatedFormat('l, d F Y H:i') }}
                </p>

                {{-- Judul --}}
                <h1 class="fw-bold mb-3">{{ $artikel['title'] }}</h1>
                <hr>

                {{-- Konten --}}
                <div class="mt-4 content-wrapper">
                    {!! $artikel['content'] !!}
                </div>
            </div>

            {{-- Sidebar: Recent Posts --}}
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px">
                    {{-- Pencarian --}}
                    <div class="mb-4">
                        <form action="{{ route('informasi.artikel.search') }}" method="GET">
                            <div class="input-group shadow-sm">
                                <input type="text" name="q" class="form-control" placeholder="Cari artikel..."
                                    value="{{ request('q') }}" required>
                                <button class="btn btn-primary text-light" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Recent Posts --}}
                    <h5 class="fw-bold mb-3">Recent Posts</h5>
                    <ul class="list-unstyled recent-posts">
                        @foreach ($recentPosts as $post)
                            <li class="mb-3">
                                <a href="{{ url('/artikel/' . $post['slug']) }}" class="fw-medium d-block">
                                    {{ $post['title'] }}
                                </a>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($post['created_at'])->translatedFormat('l, d F Y') }}
                                </small>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
