<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSP PAMI - Lembaga Sertifikasi Profesi Pengembangan Manajemen Indonesia</title>
    <meta name="description" content="LSPPM telah TERDAFTAR di OJK dengan nomor STTD.LSP-02/MS.1/2024">

    <link rel="icon" href="{{ asset('image/logo-kecil.png') }}" type="image/png">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


    @stack('styles')
</head>

<body>
    {{-- Navbar --}}
    @include('partials.navbar')

    {{-- Content --}}
    @yield('content')

    {{-- Footer --}}
    @include('partials.footer')

    <!-- Scroll to Top Button -->
    <div class="scroll-to-top" id="scrollToTop">
        <i class="bi bi-arrow-up"></i>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>


    <!-- Custom Script -->
    <script>
        // ✅ AOS Initialization
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true,
            offset: 100,
            delay: 100
        });

        // ✅ Scroll to Top Button
        const scrollToTopBtn = document.getElementById('scrollToTop');
        window.addEventListener('scroll', () => {
            if (scrollToTopBtn) {
                scrollToTopBtn.classList.toggle('show', window.pageYOffset > 300);
            }
        });
        if (scrollToTopBtn) {
            scrollToTopBtn.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }

        // ✅ Mobile Menu Toggle
        const menuToggle = document.getElementById('menuToggle');
        const navLinks = document.getElementById('navLinks');
        const navbar = document.getElementById('navbar');

        if (menuToggle && navLinks) {
            menuToggle.addEventListener('click', () => {
                navLinks.classList.toggle('active');
                const icon = menuToggle.querySelector('i');
                if (icon) {
                    icon.classList.toggle('bi-list');
                    icon.classList.toggle('bi-x');
                }
            });

            document.addEventListener('click', (e) => {
                if (!navbar.contains(e.target) && navLinks.classList.contains('active')) {
                    navLinks.classList.remove('active');
                    const icon = menuToggle.querySelector('i');
                    if (icon) {
                        icon.classList.add('bi-list');
                        icon.classList.remove('bi-x');
                    }
                }
            });
        }

        // ✅ Scroll-based Navbar Styling
        window.addEventListener('scroll', () => {
            if (navbar) {
                if (window.pageYOffset > 100) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }
        });

        // ✅ Counter Animation
        function animateCounter(element) {
            const target = parseInt(element.getAttribute('data-count')) || 0;
            const duration = 2000;
            const step = target / (duration / 16);
            let current = 0;

            const suffix = element.getAttribute('data-count-suffix') || '';

            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }

                // Gunakan pembulatan dan format angka jika mau
                const displayed = Math.floor(current).toLocaleString('id-ID');
                element.textContent = `${displayed}${suffix}`;
            }, 16);
        }

        const counterElements = document.querySelectorAll('[data-count]');
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                    animateCounter(entry.target);
                    entry.target.classList.add('animated');
                }
            });
        }, {
            threshold: 0.5
        });

        counterElements.forEach(el => counterObserver.observe(el));


        // ✅ Update Active Nav Link on Scroll
        function updateActiveNavLink() {
            const sections = document.querySelectorAll('section[id]');
            const navItems = document.querySelectorAll('.nav-links a[href^="#"]');
            let scrollPosition = window.scrollY;

            let current = '';
            sections.forEach(section => {
                if (scrollPosition >= section.offsetTop - 150) {
                    current = section.getAttribute('id');
                }
            });

            navItems.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });
        }
        window.addEventListener('scroll', updateActiveNavLink);

        // ✅ Smooth Scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href && href.length > 1 && document.querySelector(href)) {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    const headerOffset = 80;
                    const offsetTop = target.offsetTop - headerOffset;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // // ✅ Hero Parallax Effect
        // window.addEventListener('scroll', () => {
        //     const hero = document.querySelector('.hero');
        //     if (hero) {
        //         const offset = window.scrollY * 0.5;
        //         hero.style.transform = `translateY(${offset}px)`;
        //     }
        // });

        // ✅ Typing Animation
        function typeWriter(el, text, speed = 100) {
            let i = 0;
            el.innerHTML = '';
            (function type() {
                if (i < text.length) {
                    el.innerHTML += text.charAt(i++);
                    setTimeout(type, speed);
                }
            })();
        }

        const heroSection = document.querySelector('.hero');
        if (heroSection) {
            const heroObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !entry.target.classList.contains('typed')) {
                        const span = entry.target.querySelector('.hero-highlight');
                        if (span) {
                            const originalText = span.textContent;
                            span.textContent = '';
                            typeWriter(span, originalText, 50);
                            entry.target.classList.add('typed');
                        }
                    }
                });
            }, {
                threshold: 0.3
            });
            heroObserver.observe(heroSection);
        }


        // ✅ Card Hover Effects
        const cards = document.querySelectorAll('.stat-card, .scheme-card, .service-card, .article-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-10px) scale(1.02)';
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0) scale(1)';
            });
        });

        // ✅ Animate cards on page load
        window.addEventListener('load', () => {
            document.body.style.overflow = 'auto';
            cards.forEach((card, i) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, i * 100);
            });
        });

        // ✅ Additional IntersectionObserver for AOS-like elements
        const animatedEls = document.querySelectorAll('[data-aos]');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        animatedEls.forEach(el => observer.observe(el));
    </script>

    @stack('scripts')


</body>

</html>
