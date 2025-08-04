@extends('layouts.app')

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
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

    .btn-back {
        margin-top: 1rem;
    }

    @media (max-width: 768px) {
        .btn-back {
            text-align: left;
            margin-bottom: 1rem;
        }
    }

    .event-card {
        background: #ffffff;
        border-radius: 1rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        padding: 2rem;
    }

    .event-register-btn {
        transition: 0.3s ease;
    }

    .event-register-btn:hover {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>
@endpush

@section('content')
    {{-- Breadcrumb --}}
    <div class="breadcrumb-wrapper">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('informasi.event') }}">Event</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $event['title'] }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-12" data-aos="fade-up">
                <div class="event-card">
                    <div class="btn-back mb-3">
                        <a href="{{ route('informasi.event') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>

                    {{-- Gambar --}}
                    <img src="{{ asset($event['image']) }}" class="img-fluid rounded mb-4" alt="{{ $event['title'] }}">

                    {{-- Tanggal --}}
                    <p class="text-muted mb-1">
                        <i class="bi bi-clock me-2"></i>
                        {{ \Carbon\Carbon::parse($event['created_at'])->translatedFormat('l, d F Y H:i') }}
                    </p>

                    {{-- Judul --}}
                    <h2 class="fw-bold mb-3">{{ $event['title'] }}</h2>
                    <hr>

                    {{-- Konten --}}
                    <div class="mt-4 content-wrapper">
                        {!! $event['content'] !!}
                    </div>

                    {{-- Tombol Daftar --}}
                    @if (!empty($event['url']))
                        <div class="text-center mt-5">
                            <a href="{{ $event['url'] }}" target="_blank" class="btn btn-outline-warning btn-lg event-register-btn">
                                <i class="bi bi-pencil-square me-2"></i> Daftar Event
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
