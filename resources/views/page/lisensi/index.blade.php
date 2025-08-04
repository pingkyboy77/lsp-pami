@extends('layouts.app')

@section('content')
    <div class="container py-5">
        {{-- Banner Judul --}}
        <div class="btn-primary text-light text-white rounded py-3 shadow-sm mb-4 row container-fluid mx-1">
            <h5 class="p-0 m-0">{{ $license_title ?? 'Lisensi LSP Pasar Modal' }}</h5>
        </div>

        {{-- Deskripsi Awal --}}
        <div class="row mb-5">
            <span class="mb-0 text-muted">
                {{ $license_description ?? 'Sertifikasi kompetensi kerja bidang pasar modal pertama di Indonesia dilaksanakan oleh Lembaga Sertifikasi Profesi Pasar Modal (LSP-PM) yang telah memperoleh lisensi dari BNSP sebagai berikut:' }}
            </span>
        </div>

        {{-- Daftar Lisensi --}}
        <div class="row g-4 mb-5 justify-content-center">
            @foreach ($licenses ?? [] as $index => $license)
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <a data-bs-toggle="modal" data-bs-target="#previewLisensi{{ $index }}" style="cursor: zoom-in;">
                            <img src="{{ asset($license['image']) }}" alt="Lisensi {{ $index + 1 }}"
                                 class="img-fluid rounded-top w-100">
                        </a>
                        <div class="card-body">
                            <h5 class="custom-yellow fw-semibold mb-1">{{ $license['title'] ?? 'Judul Lisensi' }}</h5>
                            <p class="mb-0 text-muted small">{{ $license['subtitle'] ?? '' }}</p>
                            <p class="mb-0 text-dark small">{{ $license['desc1'] ?? '' }}</p>
                            <p class="text-dark small">{{ $license['desc2'] ?? '' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- MODAL PREVIEW --}}
        @foreach ($licenses ?? [] as $index => $license)
            <div class="modal fade" id="previewLisensi{{ $index }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content border-0 bg-transparent">
                        <img src="{{ asset($license['image']) }}" class="img-fluid rounded" alt="Preview Lisensi {{ $index + 1 }}">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
