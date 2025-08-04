<nav id="navbar" class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <!-- Logo untuk mobile -->
        <a class="navbar-brand mx-auto d-lg-none" href="{{ route('home') }}">
            <img src="{{ asset('image/logo-putih.png') }}" alt="Logo" class="hero-logo">
        </a>

        <!-- Hamburger -->
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Konten Navbar -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarContent">
            <ul class="navbar-nav text-center" style="gap: 1.25rem;">

                <!-- Logo tengah untuk desktop -->
                <li class="nav-item d-none d-lg-block">
                    <a class="navbar-brand mx-auto" href="{{ route('home') }}">
                        <img src="{{ asset('image/logo-putih.png') }}" alt="Logo" class="hero-logo">
                    </a>
                </li>

                <!-- Beranda -->
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        Beranda
                    </a>
                </li>
                
                <!-- Profil -->
                <li class="nav-item dropdown">
                    <a href="#"
                        class="nav-link dropdown-toggle {{ request()->routeIs('profil', 'lisensi', 'sambutan', 'profil.latar-belakang', 'profil.sejarah', 'profil.struktur') ? 'active' : '' }}"
                        data-bs-toggle="dropdown">
                        Profil
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item {{ request()->routeIs('profil') ? 'active' : '' }}"
                                href="{{ route('profil') }}">Profil LSP PAMI</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('lisensi') ? 'active' : '' }}"
                                href="{{ route('lisensi') }}">Lisensi</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('sambutan') ? 'active' : '' }}"
                                href="{{ route('sambutan') }}">Sambutan</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('latar-belakang') ? 'active' : '' }}" href="{{ route('profil.static', 'latar-belakang') }}">Latar
                                Belakang LSP PAMI</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('sejarah') ? 'active' : '' }}" href="{{ route('profil.static', 'sejarah') }}">Sejarah
                                LSP PAMI</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('struktur') ? 'active' : '' }}" href="{{ route(name: 'struktur') }}">Struktur Organisasi</a></li>

                    </ul>
                </li>

                <!-- Sertifikasi -->
                <li class="nav-item">
                    <a href="{{ route('sertifikasi.index') }}" class="nav-link {{ request()->routeIs('sertifikasi*') ? 'active' : '' }}">
                        Sertifikasi
                    </a>
                </li>



                <!-- Informasi -->
                <li class="nav-item dropdown">
                    <a href="#"
                        class="nav-link dropdown-toggle {{ request()->routeIs('informasi.*') ? 'active' : '' }}"
                        data-bs-toggle="dropdown">
                        Informasi
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item {{ request()->routeIs('proses-ujikom') ? 'active' : '' }}"
                                href="{{ route('proses-ujikom') }}">Proses Uji Kompetensi</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('informasi.manajemen') ? 'active' : '' }}"
                                href="{{ route('informasi.manajemen') }}">Manajemen Pengguna</a></li>

                        <!-- Submenu TUK -->
                        <li class="dropdown dropend d-lg-dropend">
                            <a class="dropdown-item dropdown-toggle {{ request()->routeIs('informasi.tuk.*') ? 'active' : '' }}"
                                href="#" data-bs-toggle="dropdown">TUK</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item {{ request()->routeIs('informasi.tuk.terdaftar') ? 'active' : '' }}"
                                        href="{{ route('coming.soon') }}">Permohonan verifikasi TUK</a></li>
                            </ul>
                        </li>

                        <li><a class="dropdown-item {{ request()->routeIs('informasi.lembaga') ? 'active' : '' }}"
                                href="{{ route('informasi.lembaga.index') }}">Lembaga Pelatihan</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('informasi.faq') ? 'active' : '' }}"
                                href="{{ route('informasi.faq') }}">FAQ</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('informasi.galeri') ? 'active' : '' }}"
                                href="{{ route('informasi.galeri') }}">Galeri Foto</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('informasi.event') ? 'active' : '' }}"
                                href="{{ route('informasi.event') }}">Event</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('informasi.artikel') ? 'active' : '' }}"
                                href="{{ route('informasi.artikel') }}">Artikel</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
</nav>
