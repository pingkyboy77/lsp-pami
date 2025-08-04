@extends('layouts.app')

@section('title', $lembaga->title . ' - LSP-PM')

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

        .breadcrumb-item+.breadcrumb-item::before {
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

        .lembaga-image {
            max-height: 400px;
            object-fit: cover;
            border-radius: 1rem;
            /* box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1); */
        }

        .content-wrapper {
            background: #fff;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-top: 2rem;
        }

        .content-wrapper img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 1rem 0;
        }

        .content-wrapper h1,
        .content-wrapper h2,
        .content-wrapper h3,
        .content-wrapper h4,
        .content-wrapper h5,
        .content-wrapper h6 {
            color: #2c3e50;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
        }

        .content-wrapper p {
            line-height: 1.8;
            margin-bottom: 1rem;
            color: #444;
        }

        .content-wrapper ul,
        .content-wrapper ol {
            margin-bottom: 1rem;
            padding-left: 2rem;
        }

        .content-wrapper li {
            margin-bottom: 0.5rem;
            line-height: 1.6;
        }

        .content-wrapper blockquote {
            border-left: 4px solid #007bff;
            margin: 1.5rem 0;
            padding: 1rem 1.5rem;
            background: #f8f9fa;
            border-radius: 0.5rem;
        }

        .content-wrapper table {
            width: 100%;
            margin: 1rem 0;
            border-collapse: collapse;
        }

        .content-wrapper table th,
        .content-wrapper table td {
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            text-align: left;
        }

        .content-wrapper table th {
            background-color: #f8f9fa;
            font-weight: 600;
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
                    <li class="breadcrumb-item"><a href="{{ route('informasi.lembaga.index') }}">Lembaga Pelatihan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $lembaga->title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Content Section -->
    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <!-- Header -->
                    <div class="text-center mb-5">
                        <h1 class="fw-bold mb-4">{{ $lembaga->title }}</h1>

                        @if ($lembaga->image && file_exists(public_path($lembaga->image)))
                            <div class="img-wrapper-lembaga">
                                <img src="{{ asset($lembaga->image) }}" alt="{{ $lembaga->title }}" class="img-fluid">
                            </div>
                        @else
                            <div
                                class="img-wrapper-lembaga bg-secondary text-white d-flex align-items-center justify-content-center">
                                <i class="bi bi-building fa-2x opacity-75"></i>
                            </div>
                        @endif


                    </div>

                    <!-- Content -->
                    <div class="content-wrapper">
                        {!! $lembaga->content !!}
                    </div>

                    <!-- Back Button -->
                    <div class="text-center mt-5">
                        <a href="{{ route('informasi.lembaga.index') }}" class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
