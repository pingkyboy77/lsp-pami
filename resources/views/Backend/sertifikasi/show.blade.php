@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Detail Sertifikasi</h4>

    <div class="card"><div class="card-body">
        <h5>{{ $sertifikasi->title }}</h5>
        <p class="text-muted">{{ $sertifikasi->description ?? '-' }}</p>
        <p><strong>Parent:</strong> {{ $sertifikasi->parent ? $sertifikasi->parent->title : '-' }}</p>
        <p><strong>Sort Order:</strong> {{ $sertifikasi->sort_order }}</p>
        <p><strong>Status:</strong> <span class="badge bg-{{ $sertifikasi->is_active ? 'success' : 'danger' }}">{{ $sertifikasi->is_active ? 'Aktif' : 'Tidak Aktif' }}</span></p>

        @if($sertifikasi->image)
            <div class="mb-2"><img src="{{ Storage::url($sertifikasi->image) }}" width="150" class="rounded"></div>
        @endif

        @if($sertifikasi->unitKompetensi)
            <hr><h6>Unit Kompetensi</h6><div>{!! $sertifikasi->unitKompetensi->content !!}</div>
        @endif
        @if($sertifikasi->persyaratanDasar)
            <hr><h6>Persyaratan Dasar</h6><div>{!! $sertifikasi->persyaratanDasar->content !!}</div>
        @endif
        @if($sertifikasi->biayaUjiKompetensi)
            <hr><h6>Biaya Uji</h6><div>{!! $sertifikasi->biayaUjiKompetensi->content !!}</div>
        @endif
    </div><div class="card-footer text-end">
        <a href="{{ route('admin.sertifikasi.index') }}" class="btn btn-secondary">Back</a>
    </div></div>
</div>
@endsection
