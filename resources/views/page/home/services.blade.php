<section class="services" id="services">
    <div class="schemes-container">
        <h2 class="section-title" data-aos="fade-up">
            {{ $service_section_title ?? 'Bidang Sertifikasi dan' }}
            <span class="hero-highlight">{{ $service_section_highlight ?? 'Layanan' }}</span>
        </h2>

        <div class="row d-flex justify-content-center">
            @foreach ($service_items ?? [] as $index => $item)
                <div class="col-6 col-md-4 col-lg-3 mb-2">
                        <a href="{{ $item['url'] }}"
                            class="text-decoration-none text-reset">
                            <div class="custom-card">
                                    <img src="{{ asset($item['icon'] ?? 'image/default-icon.svg') }}" alt="{{ $item['title'] }}"
                                        class="card-img-top">

                                <div class="card-footer-custom">
                                    <h6 style="font-size: 1rem">{{ $item['title'] }}</h6>
                                </div>
                            </div>
                        </a>
                    </div>
            @endforeach
        </div>
    </div>
</section>