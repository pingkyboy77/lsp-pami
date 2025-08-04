<section class="schemes" id="certification">
    <div class="container-fluid schemes-container py-5">
        <h2 class="section-title text-center mb-5" data-aos="fade-up">
            {{ $scheme_section_title ?? 'Skema Sertifikasi' }}
            <span class="hero-highlight">{{ $scheme_section_highlight ?? 'LSP-PAMI' }}</span>
        </h2>

        <div class="row g-4 d-flex justify-content-center">
            @foreach ($scheme_items ?? [] as $index => $scheme)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="scheme-card h-100 shadow rounded-4 overflow-hidden d-flex flex-column">
                        @if ($scheme['image'] && Storage::disk('public')->exists($scheme['image']))
                            <img src="{{ Storage::url($scheme['image']) }}" alt="{{ $scheme['title'] }}"
                                class="card-img-top">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-secondary text-white"
                                style="height: 160px;">
                                <i class="fas fa-certificate fa-2x opacity-75"></i>
                            </div>
                        @endif
                        <div class="scheme-content d-flex flex-column justify-content-between flex-grow-1 p-3">
                            <div class="mt-2">
                                <h3 class="scheme-title text-center">{{ $scheme['title'] }}</h3>
                                {{-- <p class="text-muted">{!! Str::limit($scheme['description'], 100) !!}</p> --}}
                            </div>
                            {{-- <a href="{{ $scheme['url'] }}" class="scheme-btn btn w-100 text-white"
                                style="background: linear-gradient(90deg, #7f5af0 0%, #f0c674 100%);">
                                <i class="bi bi-arrow-right me-2"></i>
                                {{ $scheme['button'] ?? 'Lihat Detail Sertifikasi' }}
                            </a> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
