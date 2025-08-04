<section class="hero" id="home">
    <div class="container">
        <div class="row align-items-center hero-container">
            <!-- KIRI: Teks -->
            <div class="col-lg-5 col-md-12 pt-md-3 hero-content" data-aos="fade-right">
                <h1>
                    {{ $hero['title'] ?? 'Judul Hero Default' }} <br>
                    <span class="hero-highlight"  >{{ $hero['highlight'] ?? 'Highlight Default' }}</span>
                </h1>
                <p class="hero-subtitle">
                    {{ $hero['description'] ?? 'Deskripsi singkat hero section.' }}
                </p>
                <div class="hero-cta d-flex gap-2 flex-wrap">
                    <a href="{{ $hero['cta_1']['link'] ?? '#' }}" class="btn-primary text-light text-sm">
                        <i class="{{ $hero['cta_1']['icon'] ?? 'bi bi-award' }} me-2 text-light"></i>
                        {{ $hero['cta_1']['text'] ?? 'Tombol 1' }}
                    </a>
                    <a href="{{ $hero['cta_2']['link'] ?? '#' }}" class="btn-secondary text-sm">
                        <i class="{{ $hero['cta_2']['icon'] ?? 'bi bi-info-circle' }} me-2"></i>
                        {{ $hero['cta_2']['text'] ?? 'Tombol 2' }}
                    </a>
                </div>
            </div>

            <!-- KANAN: Gambar -->
            <div class="col-lg-7 col-md-12 text-left hero-visual" data-aos="fade-left" data-aos-delay="200">
                <div class="hero-card floating d-inline-block w-100">
                    @if (!empty($hero['badge']))
                        <div class="ojk-badge text-light">
                            <i class="{{ $hero['badge']['icon'] ?? 'bi bi-patch-check' }} me-2 text-light"></i>
                            {{ $hero['badge']['text'] ?? 'TERDAFTAR OJK' }}
                        </div>
                    @endif
                    <img src="{{ asset($hero['image'] ?? 'image/banner.png') }}" alt="Banner"
                         class="img-fluid banner-responsive">
                    <div class="mt-3">
                        <small><strong>{{ $hero['date'] ?? 'Per Tanggal Default' }}</strong></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
