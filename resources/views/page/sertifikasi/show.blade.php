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

    .tabulator-tabs button {
        background: none;
        border: none;
        font-weight: 600;
        padding: 0.5rem 1rem;
        cursor: pointer;
        border-bottom: 3px solid transparent;
    }

    .tabulator-tab.active {
        border-color: #007bff;
        color: #007bff;
    }

    .tabulator-pane {
        display: none;
    }

    .tabulator-pane.show {
        display: block;
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

    {{-- Header --}}
    <div class="py-5 bg-light">
        <div class="container text-center">
            <h1 class="fw-bold mb-4">{{ $sertifikasi->title }}</h1>

            {{-- Gambar --}}
            @if ($sertifikasi->image && Storage::disk('public')->exists($sertifikasi->image))
                <div class="text-center mb-4">
                    <img src="{{ Storage::url($sertifikasi->image) }}" class="img-fluid rounded" style="max-height: 300px; object-fit: cover;" alt="{{ $sertifikasi->title }}">
                </div>
            @endif

            {{-- Deskripsi --}}
            <p class="lead text-muted mb-4">
                {!! $sertifikasi->description !!}
            </p>

            @php
                $unit = $sertifikasi->unitKompetensi?->content;
                $syarat = $sertifikasi->persyaratanDasar?->content;
                $biaya = $sertifikasi->biayaUjiKompetensi?->content;
            @endphp

            @if ($unit || $syarat || $biaya)
                {{-- Tabs --}}
                <div class="tabulator-tabs d-flex justify-content-center gap-3 border-bottom mb-4">
                    @if($unit)
                        <button class="tabulator-tab active" data-target="#unit">Unit Kompetensi</button>
                    @endif
                    @if($syarat)
                        <button class="tabulator-tab {{ !$unit ? 'active' : '' }}" data-target="#syarat">Persyaratan Dasar</button>
                    @endif
                    @if($biaya)
                        <button class="tabulator-tab {{ (!$unit && !$syarat) ? 'active' : '' }}" data-target="#biaya">Biaya Uji Kompetensi</button>
                    @endif
                </div>

                <div class="tabulator-content text-start">
                    @if($unit)
                        <div class="tabulator-pane show" id="unit">
                            {!! $unit !!}
                        </div>
                    @endif
                    @if($syarat)
                        <div class="tabulator-pane {{ !$unit ? 'show' : '' }}" id="syarat">
                            {!! $syarat !!}
                        </div>
                    @endif
                    @if($biaya)
                        <div class="tabulator-pane {{ (!$unit && !$syarat) ? 'show' : '' }}" id="biaya">
                            {!! $biaya !!}
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tabs = document.querySelectorAll(".tabulator-tab");
        const panes = document.querySelectorAll(".tabulator-pane");

        tabs.forEach(tab => {
            tab.addEventListener("click", function () {
                tabs.forEach(t => t.classList.remove("active"));
                panes.forEach(p => p.classList.remove("show"));

                this.classList.add("active");
                const target = document.querySelector(this.dataset.target);
                if (target) {
                    target.classList.add("show");
                }
            });
        });
    });
</script>
@endpush
