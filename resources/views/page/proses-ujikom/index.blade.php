@extends('layouts.app')

@section('content')
    <div class="container py-5">
        {{-- <h2 class="fw-bold text-primary-emphasis"></h2> --}}
        <h2 class="modern-title">{{ $title ?? 'Proses Ujikompetensi LSP PAMI' }}</h2>
            <hr class="modern-hr">
        {{-- Gambar Dinamis --}}
        <div class="row mt-2 g-4">
            @forelse ($struktur_images ?? [] as $img)
                <div class="col-6">
                    <div class=" border-0 shadow-sm">
                        <a data-bs-toggle="modal" data-bs-target="#modalStruktur{{ $loop->index }}" style="cursor: zoom-in;">
                            <img src="{{ asset($img['path']) }}" class="img-fluid rounded" alt="{{ $img['alt'] ?? 'Proses Ujikom' }}">
                        </a>
                    </div>
                </div>

                {{-- Modal Preview --}}
                <div class="modal fade" id="modalStruktur{{ $loop->index }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content border-0 bg-transparent">
                            <img src="{{ asset($img['path']) }}" class="img-fluid rounded" alt="{{ $img['alt'] ?? 'Preview Ujikom' }}">
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning">Belum ada gambar Proses Ujikom yang ditampilkan.</div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
