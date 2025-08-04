<style>
    .logo-box {
        width: 200px;
        height: 180px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #fff;
        border-radius: 8px;
        padding: 10px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .logo-img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .swiper-slide {
        height: auto !important;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .logo-box:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
    }
</style>


<section class="py-5 text-center bg-white">
    <div class="container">
        <h3 class="fw-bold mb-5">
            Asosiasi <span
                style="background: linear-gradient(to right, #9b59b6, #e67e22); -webkit-background-clip: text; color: transparent;">Pendiri</span>
        </h3>

        <div class="association-slider swiper">
            <div class="swiper-wrapper">
                @foreach ($associations as $association)
                    <div class="swiper-slide d-flex justify-content-center align-items-center">
                        <div class="logo-box">
                            <img src="{{ asset($association['image']) }}" alt="{{ $association['name'] }}"
                                class="logo-img">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</section>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
    new Swiper('.association-slider', {
        slidesPerView: 3,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 1000, // 1 detik antar slide
            disableOnInteraction: false,
        },
        speed: 1000, // animasi geser 1 detik
        breakpoints: {
            320: {
                slidesPerView: 2,
                spaceBetween: 10
            },
            576: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            768: {
                slidesPerView: 4,
                spaceBetween: 30
            },
        },
    });
</script>
@endpush

