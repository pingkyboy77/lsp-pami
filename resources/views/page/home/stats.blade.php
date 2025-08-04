<section class="stats">
    <h2 class="stats-title text-center mb-5" data-aos="fade-up">{{ $stat->title ?? 'Tersebar di seluruh Indonesia' }}</h2>

    <div class="stats-map text-center mb-4">
        @if (!empty($stat->map_image))
            <img src="{{ asset($stat->map_image) }}" class="img-fluid" alt="Peta Indonesia">
        @endif
    </div>

    <div class="container stats-container">
        @foreach($stat->items ?? [] as $index => $item)
            <div class="d-grid justify-content-center align-items-center mb-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="stat-number" data-count="{{ $item['count'] ?? 0 }}">{{ $item['count'] ?? 0 }}</div>
                <div class="stat-label d-flex justify-content-center align-items-center">{{ $item['label'] ?? '' }}</div>
            </div>
        @endforeach
    </div>
</section>