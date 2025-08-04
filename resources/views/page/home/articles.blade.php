<div class="schemes-container my-5">
    <h2 class="section-title" data-aos="fade-up">
        Artikel dan Berita </span>
    </h2>

    <div class="articles-grid">
        @forelse ($articles ?? [] as $index => $article)
            <div class="col-12" data-aos="fade-up">
                <a href="{{ route('informasi.artikel.show', $article->slug) }}"
                    class="text-decoration-none text-dark h-100 d-block">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-shadow">
                        @if ($article->image && file_exists(public_path($article->image)))
                            <img src="{{ asset($article->image) }}" alt="{{ $article->title }}"
                                class="card-img-top img-fluid rounded-top" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded-top"
                                style="height: 200px;">
                                <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <small class="text-muted mb-1"><i class="bi bi-clock"></i>
                                {{ \Carbon\Carbon::parse($article->created_at)->translatedFormat('l, d F Y H:i') }}
                            </small>
                            <h5 class="fw-semibold mb-2">{{ $article->title }}</h5>
                            <p class="text-muted small flex-grow-1">
                                {{ Str::limit(strip_tags($article->content), 100) }}
                            </p>
                        </div>

                        <div class="card-footer bg-transparent border-0">
                            <span class="text-primary small fw-medium">
                                Baca selengkapnya <i class="bi bi-arrow-right"></i>
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="w-100 text-center" data-aos="fade-up">
                <img src="{{ asset('image/berita-kosong.png') }}" alt="Tidak ada artikel"
                    style="max-width: 300px; margin: 2rem auto;">
                <p class="text-black mt-3">Belum ada artikel atau berita yang tersedia.</p>
            </div>
        @endforelse
    </div>

        <div style="text-align: center; margin-top: 3rem;" data-aos="fade-up" data-aos-delay="400">
            <a href="{{ route('informasi.artikel') }}" class="btn-primary text-white">
                <i class="bi bi-arrow-right me-2 text-white"></i>
                Lihat Semua Berita
            </a>
        </div>
</div>
</div>
