<footer class="footer" id="contact">
    <div class="footer-container">
        <div class="footer-section" data-aos="fade-up" data-aos-delay="0">
            <img src="{{ asset($footer_logo ?? 'image/logo-putih.png') }}" alt="Logo" class="hero-logo">
            <p>{{ $footer_description ?? 'Lembaga Sertifikasi Profesi Pengembangan Manajemen Indonesia' }}</p>

            <!-- Embed Google Maps -->
            @if (!empty($footer_map_embed))
                <div class="footer-map" style="margin-bottom: 1rem;">
                    {!! '<iframe src="'. $footer_map_embed .'" width="100%" height="200" style="border:0; border-radius: 12px;" allowfullscreen="" loading="lazy"></iframe>' !!}
                </div>
            @endif

            <p>{{ $footer_address ?? 'Jl. Ampera Raya No.61, Ragunan, Jakarta Selatan 12550' }}</p>

            <div class="social-links">
                @foreach ($footer_socials ?? [] as $social)
                    <a href="{{ $social['url'] }}" class="social-link" target="_blank" rel="noopener">
                        <i class="{{ $social['icon'] }}"></i>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="footer-section" data-aos="fade-up" data-aos-delay="100">
            <h4>{{ $footer_contact_title ?? 'Contact Us' }}</h4>
            <p><i class="bi bi-telephone me-2"></i> {{ $footer_phone ?? '+62 21-7999-6233' }}</p>
            <p><i class="bi bi-envelope me-2"></i> {{ $footer_email ?? 'info@lsp-pm.com' }}</p>
            <p><i class="bi bi-geo-alt me-2"></i> {{ $footer_city ?? 'Jakarta Selatan, Indonesia' }}</p>
        </div>

        <div class="footer-section" data-aos="fade-up" data-aos-delay="200">
            <h4>{{ $footer_certification_title ?? 'Sertifikasi' }}</h4>
            @foreach ($footer_certification_links ?? [] as $link)
                <p><a href="{{ $link['url'] }}">• {{ $link['label'] }}</a></p>
            @endforeach
        </div>

        <div class="footer-section" data-aos="fade-up" data-aos-delay="300">
            <h4>{{ $footer_subscription_title ?? 'Subscription' }}</h4>
            <p>{{ $footer_subscription_text ?? 'Dapatkan informasi terbaru tentang program sertifikasi dan berita industri pasar modal' }}</p>
            <div style="margin-top: 1rem;">
                <input type="email" placeholder="Email Address" 
                       style="width: 100%; padding: 0.75rem; border: none; border-radius: 25px; margin-bottom: 1rem; background: rgba(255,255,255,0.1); color: white; backdrop-filter: blur(10px);">
                <a href="{{ $footer_subscription_url ?? '#' }}" class="btn-primary" style="display: inline-block; padding: 0.75rem 2rem;">
                    {{ $footer_subscription_button ?? 'Subscribe' }}
                </a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p> &copy; 2025 Krisna Yuda Nugraha - Lembaga Sertifikasi Profesi Pengembangan Manajemen Indonesia. All rights reserved.</p>
    </div>
</footer>
