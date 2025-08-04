@extends('layouts.app')

@section('content')
    <div class="container py-5">
        {{-- Banner Judul --}}
        <div class="btn-primary text-light text-white rounded px-4 py-3 shadow-sm mb-4 d-grid">
            <h2 class="fw-bold text-light">{{ $sambutan->page_title ?? 'Sambutan' }}</h2>
        </div>

        {{-- Dewan Pengarah --}}
        <div class="row align-items-center mb-5">
            <div class="col-lg-4 text-center mb-4 mb-lg-0">
                <img src="{{ asset($sambutan->pengarah_image ?? 'image/sambutan1.png') }}" class="img-fluid rounded shadow" alt="{{ $sambutan->pengarah_name ?? 'Nama Pengarah' }}">
                <h5 class="mt-3 mb-0 fw-bold">{{ $sambutan->pengarah_name ?? 'Nama Pengarah' }}</h5>
                <p class="text-muted small">{{ $sambutan->pengarah_title ?? 'Sambutan Dewan Pengarah' }}</p>
            </div>
            <div class="col-lg-8">
                <div class="bg-light p-4 rounded shadow-sm text-justify text-muted">
                    {!! $sambutan->pengarah_content ?? '
                        <p>Saya atas nama Dewan Pengarah menyambut gembira atas kontribusi LSPPM di Industri Pasar Modal...</p>
                        <p>...hingga akhirnya LSPPM diharapkan menjadi lembaga yang mampu mendukung industri pasar modal dengan SDM yang kompeten dan profesional.</p>
                    ' !!}
                </div>
            </div>
        </div>

        {{-- Dewan Pelaksana --}}
        <div class="row align-items-center flex-lg-row-reverse mb-5">
            <div class="col-lg-4 text-center mb-4 mb-lg-0">
                <img src="{{ asset($sambutan->pelaksana_image ?? 'image/sambutan2.png') }}" class="img-fluid rounded shadow" alt="{{ $sambutan->pelaksana_name ?? 'Nama Pelaksana' }}">
                <h5 class="mt-3 mb-0 fw-bold">{{ $sambutan->pelaksana_name ?? 'Nama Pelaksana' }}</h5>
                <p class="text-muted small">{{ $sambutan->pelaksana_title ?? 'Sambutan Dewan Pelaksana' }}</p>
            </div>
            <div class="col-lg-8">
                <div class="bg-light p-4 rounded shadow-sm text-justify text-muted">
                    {!! $sambutan->pelaksana_content ?? '
                        <p>Kebutuhan profesi di industri keuangan khususnya pasar modal terus meningkat...</p>
                        <p><strong>...LSPPM hadir sebagai solusi kebutuhan sertifikasi profesi yang relevan dan diakui secara nasional.</strong></p>
                        <p>Dengan dukungan asosiasi dan pemerintah, LSPPM berkomitmen mencetak SDM unggul di bidang pasar modal.</p>
                    ' !!}
                </div>
            </div>
        </div>
    </div>
@endsection
