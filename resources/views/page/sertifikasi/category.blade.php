@extends('layouts.app')

@section('title', $sertifikasi->title . ' - LSP-PM')

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

    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
    }

    .transition {
        transition: all 0.3s ease-in-out;
    }

    .card-custom {
        border-radius: 1rem;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .card-custom:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
    }

    .icon-circle {
        /* background: linear-gradient(135deg, #6f42c1, #d63384); */
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
    }
</style>
@endpush

@section('content')

    <!-- Breadcrumb -->
    <div class="breadcrumb-wrapper">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('sertifikasi.index') }}">Sertifikasi</a></li>
                    @if($sertifikasi->parent)
                        <li class="breadcrumb-item">
                            <a href="{{ route('sertifikasi.show', $sertifikasi->parent->slug) }}">
                                {{ $sertifikasi->parent->title }}
                            </a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ $sertifikasi->title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Header Section -->
    <div class="py-5 bg-light">
        <div class="container text-center">
            <h1 class="fw-bold mb-4">{{ $sertifikasi->title }}</h1>
            <p class="lead text-muted mb-5">
                {!! $sertifikasi->description !!}
            </p>

            <div class="row">
                @forelse ($sertifikasi->children as $child)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <a href="{{ route('sertifikasi.show', $child->slug) }}" class="text-decoration-none text-reset">
                            <div class="card card-custom h-100 text-center card-blue-custom">
                                <div class="card-body">
                                    <div class="icon-circle">
                                        <i class="bi bi-card-heading text-light"></i>
                                    </div>
                                    <h5 class="fw-bold text-light">{{ $child->title }}</h5>
                                    <p class="text-muted small">
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted">Belum ada program sertifikasi di bawah skema ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
