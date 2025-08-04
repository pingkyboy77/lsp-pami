@extends('layouts.app')

@section('content')
    <div class="container py-5">

        {{-- Header Title --}}
        <div class="btn-primary text-light text-white rounded py-3 shadow-sm mb-4 row container-fluid mx-1">
            <h5 class="p-0 m-0">{{ $title ?? 'Struktur Organisasi LSP - PAMI' }}</h5>
        </div>

        {{-- Gambar Dinamis --}}
        <div class="row mt-3 g-4">
            @forelse ($struktur_images ?? [] as $img)
                <div class="col-6 d-flex justify-content-center">
                    <div class=" border-0 ">
                        <a data-bs-toggle="modal" data-bs-target="#modalStruktur{{ $loop->index }}" style="cursor: zoom-in;">
                            <img src="{{ asset($img['path']) }}" class="img-fluid rounded" alt="{{ $img['alt'] ?? 'Struktur Organisasi' }}">
                        </a>
                    </div>
                </div>

                {{-- Modal Preview --}}
                <div class="modal fade" id="modalStruktur{{ $loop->index }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content border-0 bg-transparent">
                            <img src="{{ asset($img['path']) }}" class="img-fluid rounded" alt="{{ $img['alt'] ?? 'Preview Struktur' }}">
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning">Belum ada gambar struktur organisasi yang ditampilkan.</div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
