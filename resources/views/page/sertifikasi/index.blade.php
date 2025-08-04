@extends('layouts.app')

@section('title', 'Skema Sertifikasi')

@push('styles')
    <style>
        .custom-card {
            border: none;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .custom-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .card-img-top {
            height: 160px;
            object-fit: cover;
        }

        .card-footer-custom {
            background: var(--dark-gradient);
            color: #fff;
            padding: 0.75rem 1rem;
            min-height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-footer-custom h6 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
            text-align: center;
        }

        .program-badge {
            font-size: 0.75rem;
        }
    </style>
@endpush

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="modern-title">Skema Sertifikasi LSP – PAMI</h2>
            <hr class="modern-hr">

            <div class="row g-4">
                @forelse ($parentSertifikasi as $certification)
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('sertifikasi.show', $certification->slug) }}"
                            class="text-decoration-none text-reset">
                            <div class="custom-card">
                                @if ($certification->image && Storage::disk('public')->exists($certification->image))
                                    <img src="{{ Storage::url($certification->image) }}" alt="{{ $certification->title }}"
                                        class="card-img-top">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-secondary text-white"
                                        style="height: 160px;">
                                        <i class="fas fa-certificate fa-2x opacity-75"></i>
                                    </div>
                                @endif

                                <div class="card-footer-custom">
                                    <h6>{{ $certification->title }}</h6>
                                </div>

                                @if ($certification->children->count() > 0)
                                    <span class="badge bg-success position-absolute top-0 end-0 m-2 program-badge">
                                        {{ $certification->children->count() }} Program
                                    </span>
                                @endif
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-search fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">Belum Ada Program Sertifikasi</h4>
                            <p class="text-muted">Program sertifikasi sedang dalam tahap pengembangan.<br>Silakan kembali
                                lagi nanti.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
