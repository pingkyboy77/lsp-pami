<div class="p-3 fs-5 fw-bold border-bottom">
    <img src="{{ asset('image/logo-putih.png') }}" alt="Logo" height="50">
</div>

<ul class="nav nav-pills flex-column">
    <!-- Dashboard -->
    <li class="nav-item">
        <a href="{{ route('admin.dashboard') }}"
            class="nav-link text-white {{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <i class="bx bx-home me-2"></i> Dashboard
        </a>
    </li>

    <!-- User Management -->
    <li class="nav-item">
        <a href="{{ route('admin.users.index') }}"
            class="nav-link text-white {{ request()->is('admin/users*') ? 'active' : '' }}">
            <i class="bx bx-user me-2"></i> User Management
        </a>
    </li>
    <li class="nav-item">
    <a href="{{ route('admin.peserta-sertifikat.index') }}"
        class="nav-link {{ request()->routeIs('admin.peserta-sertifikat.*') ? 'active text-white' : 'text-light' }}">
        <i class="bx bx-certification me-2"></i>
        Peserta Pemegang Sertifikat
    </a>
</li>
    <li class="nav-item">
    <a href="{{ route('admin.asesor.index') }}"
        class="nav-link {{ request()->routeIs('admin.asesor.*') ? 'active text-white' : 'text-light' }}">
        <i class="bx bx-certification me-2"></i>
        Asesor
    </a>
</li>




    <!-- Site Configuration -->
    <li class="nav-item">
        <a class="nav-link text-white d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
            href="#siteConfigSections" role="button"
            aria-expanded="{{ request()->is('admin/site*') ? 'true' : 'false' }}" aria-controls="siteConfigSections">
            <span><i class="bx bx-cog me-2"></i> Site Configuration</span>
            <i class="bx bx-chevron-down"></i>
        </a>
        <div class="collapse {{ request()->is('admin/site*') ? 'show' : '' }}" id="siteConfigSections">
            <ul class="nav flex-column ms-3">
                <li class="nav-item">
                    <a href="{{ route('admin.site.footer.index') }}"
                        class="nav-link text-white {{ request()->is('admin/site/footer*') ? 'active' : '' }}">
                        <i class="fa-solid fa-shoe-prints me-2"></i> Footer Settings
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <!-- Homepage Management -->
    <li class="nav-item">
        <a class="nav-link text-white d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
            href="#homepageSections" role="button"
            aria-expanded="{{ request()->is('admin/home*') ? 'true' : 'false' }}" aria-controls="homepageSections">
            <span><i class="bx bx-layout me-2"></i> Homepage Management</span>
            <i class="bx bx-chevron-down"></i>
        </a>
        <div class="collapse {{ request()->is('admin/home*') ? 'show' : '' }}" id="homepageSections">
            <ul class="nav flex-column ms-3">
                <li class="nav-item">
                    <a href="{{ route('admin.home.hero.index') }}"
                        class="nav-link text-white {{ request()->is('admin/home/hero*') ? 'active' : '' }}">
                        <i class="bx bx-image me-2"></i> Hero Section
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.home.statistics.index') }}"
                        class="nav-link text-white {{ request()->is('admin/home/statistics*') ? 'active' : '' }}">
                        <i class="bx bx-bar-chart-alt me-2"></i> Statistics Section
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.home.profile.index') }}"
                        class="nav-link text-white {{ request()->is('admin/home/profile*') ? 'active' : '' }}">
                        <i class="bx bx-id-card me-2"></i> Profile Section
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('admin.home.certifications.index') }}"
                        class="nav-link text-white {{ request()->is('admin/home/certifications*') ? 'active' : '' }}">
                        <i class="bx bx-certification me-2"></i> Certifications
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ route('admin.home.services.index') }}"
                        class="nav-link text-white {{ request()->is('admin/home/services*') ? 'active' : '' }}">
                        <i class="bx bx-briefcase me-2"></i> Services
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.home.associations.index') }}"
                        class="nav-link text-white {{ request()->is('admin/home/associations*') ? 'active' : '' }}">
                        <i class="bx bx-group me-2"></i> Association
                    </a>
                </li>
            </ul>
        </div>
    </li>


    <!-- LSP Profile Management -->
    <li class="nav-item">
        <a class="nav-link text-white d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
            href="#lspProfileSections" role="button"
            aria-expanded="{{ request()->is('admin/lsp-profile*') ? 'true' : 'false' }}"
            aria-controls="lspProfileSections">
            <span><i class="bx bx-building me-2"></i> LSP Profile Management</span>
            <i class="bx bx-chevron-down"></i>
        </a>
        <div class="collapse mb-4 {{ request()->is('admin/lsp-profile*') ? 'show' : '' }}" id="lspProfileSections">
            <ul class="nav flex-column ms-3">
                <li class="nav-item">
                    <a href="{{ route('admin.lsp.index') }}"
                        class="nav-link text-white {{ request()->is('admin/lsp-profile') || request()->is('admin/lsp-profile/*/edit') ? 'active' : '' }}">
                        <i class="bi bi-person-badge me-2"></i> Main Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.lsp.sections.index') }}"
                        class="nav-link text-white {{ request()->is('admin/lsp-profile/sections*') ? 'active' : '' }}">
                        <i class="bi bi-layout-text-window me-2"></i> Profile Sections
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.licenses.index') }}"
                        class="nav-link text-white {{ request()->is('admin/licenses*') ? 'active' : '' }}">
                        <i class="bi bi-award me-2"></i> Licenses Management
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.sambutan.index') }}"
                        class="nav-link text-white {{ request()->is('admin/sambutan*') ? 'active' : '' }}">
                        <i class="bx bx-user-voice me-2"></i> Sambutan Management
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.paralel.edit', 'latar-belakang') }}"
                        class="nav-link text-white {{ request()->is('admin/paralel/latar-belakang*') ? 'active' : '' }}">
                        <i class="bi bi-book me-2"></i> Latar Belakang Management
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.paralel.edit', 'sejarah-lsppm') }}"
                        class="nav-link text-white {{ request()->is('admin/paralel/sejarah-lsppm*') ? 'active' : '' }}">
                        <i class="bi bi-journal-text me-2"></i> Sejarah Management
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.struktur.index') }}"
                        class="nav-link text-white {{ request()->is('admin/struktur*') ? 'active' : '' }}">
                        <i class="bi bi-diagram-3 me-2"></i> Struktur Organisasi
                    </a>
                </li>
            </ul>
    <li class="nav-item">
        <a href="{{ route('admin.sertifikasi.index') }}"
            class="nav-link text-white {{ request()->is('admin/sertifikasi*') ? 'active' : '' }}">
            <i class="bx bx-certification me-2"></i> Sertifikasi Management
        </a>
    </li>
    {{-- informasi side bar --}}
    <li class="nav-item mb-3">
        <a class="nav-link text-white d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
            href="#informasiConfigSections" role="button"
            aria-expanded="{{ request()->is('admin/ujikom*') ? 'true' : 'false' }}"
            aria-controls="informasiConfigSections">
            <span><i class="bx bx-phone me-2"></i> Informasi Management</span>
            <i class="bx bx-chevron-down"></i>
        </a>
        <div class="collapse {{ request()->is('admin/site*') ? 'show' : '' }}" id="informasiConfigSections">
            <ul class="nav flex-column ms-3">
                <li class="nav-item">
                    <a href="{{ route('admin.ujikom.index') }}"
                        class="nav-link text-white {{ request()->is('admin/ujikom*') ? 'active' : '' }}">
                        <i class="bx bx-certification me-2"></i> Proses Ujikom Management
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.galeri.index') }}"
                        class="nav-link text-white {{ request()->is('admin/galeri*') ? 'active' : '' }}">
                        <i class="bx bx-certification me-2"></i> Galeri Kegiatan Management
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.lembaga.index') }}"
                        class="nav-link text-white {{ request()->is('admin/lembaga*') ? 'active' : '' }}">
                        <i class="bx bx-certification me-2"></i> lembaga
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.faq.index') }}"
                        class="nav-link text-white {{ request()->is('admin/faq*') ? 'active' : '' }}">
                        <i class="bx bx-certification me-2"></i> Faq
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.event.index') }}"
                        class="nav-link text-white {{ request()->is('admin/event*') ? 'active' : '' }}">
                        <i class="bx bx-certification me-2"></i> Event
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.artikel.index') }}"
                        class="nav-link text-white {{ request()->is('admin/artikel*') ? 'active' : '' }}">
                        <i class="bx bx-certification me-2"></i> Artikel
                    </a>
                </li>
            </ul>
        </div>
    </li>
    </div>
    </li>
</ul>
