@extends('layouts.app')

@section('title', 'Lembaga Pelatihan')


@section('content')
    <div class="container py-5">
        <h2 class="modern-title">Lembaga Pelatihan</h2>
        <hr class="modern-hr">

        {{-- Search Form --}}
        <div class="row mb-4">
            <div class="col-12">
                <form action="{{ route('informasi.lembaga.search') }}" method="GET">
                    <div class="input-group input-group-lg shadow-sm">
                        <input type="text" name="q" class="form-control shadow-none" placeholder="Cari lembaga pelatihan..."
                            value="{{ request('q') }}" required>
                        <button class="btn btn-primary text-light" type="submit">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Grid Cards --}}
        <div class="row g-4">
            @forelse ($lembaga_items as $lembaga)
                <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up">
                    <a href="{{ route('informasi.lembaga.show', $lembaga->slug) }}" class="text-decoration-none text-reset">
                        <div class="custom-card">
                            @if ($lembaga->image && file_exists(public_path($lembaga->image)))
                                <img src="{{ asset($lembaga->image) }}" alt="{{ $lembaga->title }}" class="card-img-top">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-secondary text-white"
                                    style="height: 160px;">
                                    <i class="bi bi-building fa-2x opacity-75"></i>
                                </div>
                            @endif

                            <div class="card-footer-custom">
                                <h6>{{ $lembaga->title }}</h6>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center" data-aos="fade-up">
                    <img src="{{ asset('image/berita-kosong.png') }}" alt="Tidak ada lembaga"
                        style="max-width: 300px; margin: 2rem auto;">
                    <p class="text-black mt-3">Belum ada lembaga pelatihan yang tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
