@extends('layouts.app')

@section('content')
    <style>
        @media (max-width: 768px) {
            .two-column-content {
                column-count: 1 !important;
            }
        }
    </style>
    <div class="container py-5">
        {{-- Header Section --}}
        <div class="btn-primary text-light text-white rounded py-3 shadow-sm mb-4 row container-fluid mx-1">
            <h5 class="p-0 m-0">{{ $title ?? 'Halaman Informasi' }}</h5>
        </div>
        {{-- Optional Banner Image --}}
        @if (!empty($banner))
            <div class="mb-3">
                <div class="card shadow-sm border-0 rounded p-3"> {{-- kasih padding 3 --}}
                    <img src="{{ asset($banner) }}" class="card-img-top rounded m-3"
                        alt="Banner {{ $title }}"
                        style="max-height: 300px; object-fit: contain; width: calc(100% - 2rem);">

                </div>
            </div>
        @endif

        {{-- Content Section --}}
        <div class="bg-white p-4 rounded shadow-sm text-muted two-column-content"
            style="column-count: 2; column-gap: 2rem; text-align: justify;">
            {!! $content ?? '<p>Konten belum tersedia.</p>' !!}
        </div>
    </div>
@endsection
