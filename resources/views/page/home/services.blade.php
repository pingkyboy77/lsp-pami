<section class="services" id="services">
    <div class="schemes-container">
        <h2 class="section-title" data-aos="fade-up">
            {{ $service_section_title ?? 'Bidang Sertifikasi dan' }}
            <span class="hero-highlight">{{ $service_section_highlight ?? 'Layanan' }}</span>
        </h2>

        <div class="row d-flex justify-content-center">
            @foreach ($service_items ?? [] as $index => $item)
                {{-- <div class="col-lg-3 col-md-6 mb-4">
                    <a href="{{ $item['url'] ?? '#' }}" class="text-decoration-none text-white">
                        <div class="service-card shadow"
                             data-aos="fade-up"
                             data-aos-delay="{{ $index * 100 }}"
                             style="background-image: url('{{ asset($item['icon'] ?? 'image/default-icon.svg') }}'); background-size: cover; background-position: center; height: 220px; border-radius: 12px; display: flex; align-items: flex-end; overflow: hidden;">
                            <div class="w-100 p-3">
                                <h3 class="service-title m-0 text-center">{{ $item['title'] ?? 'Judul Layanan' }}</h3>
                            </div>
                        </div>
                    </a>
                </div> --}}

                <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ $item['url'] }}"
                            class="text-decoration-none text-reset">
                            <div class="custom-card">
                                    <img src="{{ asset($item['icon'] ?? 'image/default-icon.svg') }}" alt="{{ $item['title'] }}"
                                        class="card-img-top">

                                <div class="card-footer-custom">
                                    <h6>{{ $item['title'] }}</h6>
                                </div>
                            </div>
                        </a>
                    </div>
            @endforeach
        </div>
    </div>
</section>
