<section class="profile" id="profile">
    <div class="profile-container">
        <div class="profile-content" data-aos="fade-right">
            <h2>
                
                <span class="profile-highlight">
                    {{ $profile->title ?? 'Lembaga Sertifikasi Profesi Pengembangan Manajemen Indonesia (LSP PAMI)' }}
                </span>
            </h2>

            <p class="profile-text">
                {{ $profile->paragraph_1 ?? 'LSP PAMI merupakan lembaga sertifikasi yang berkomitmen untuk meningkatkan kualitas sumber daya manusia di bidang pasar modal melalui program sertifikasi profesi yang berkualitas dan terpercaya.' }}
            </p>

            <p class="profile-text">
                {{ $profile->paragraph_2 ?? 'Dengan dukungan dari berbagai stakeholder industri pasar modal, LSP PAMI hadir untuk memastikan setiap profesional memiliki kompetensi yang sesuai dengan standar industri.' }}
            </p>

            <a href="{{ $profile->button_url ?? '#' }}" class="btn btn-primary text-light">
                <i class="bi bi-arrow-right me-2 text-light"></i>
                {{ $profile->button_text ?? 'Jelajahi Program Kami' }}
            </a>
        </div>

        <div class="profile-visual" data-aos="fade-left" data-aos-delay="200">
            <div class="profile-card">
                <p>
                    {{ $profile->card_text ?? 'Mengenal lebih dekat Lembaga Sertifikasi Profesi Pengembangan Manajemen Indonesia' }}
                </p>

                <div class="video-responsive mt-4">
                    <iframe width="560" height="315"
                        src="{{ $profile->video_url ?? 'https://www.youtube.com/embed/cXp_0VJwwaY' }}"
                        title="Video Profil"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>
