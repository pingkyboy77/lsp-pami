{{-- @dd($main_section) --}}
@extends('layouts.app')

@section('content')
    <div class="container py-5">
        {{-- Banner Judul --}}
        <div class="btn-primary text-light text-white rounded px-4 py-3 shadow-sm mb-4 row container-fluid mx-1">
            <h5 class="p-0 mb-0">{{ $main_section->title ?? 'Profil LSP Pengembangan Manajemen Indonesia' }}</h5>
        </div>

        {{-- Section Gambar dan Konten Utama --}}
        <div class="row mb-5">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <img src="{{ asset($main_section->image ?? 'image/profil.jpg') }}" alt="LSP PAMI"
                    class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-8">
                {!! $main_section->content ??
                    '
                                    <p class="text-justify text-muted">
                                        <strong>Lembaga Sertifikasi Pengembangan Manajemen Indonesia (LSP PAMI)</strong> adalah lembaga pelaksana kegiatan sertifikasi kompetensi kerja di bidang Pasar Modal yang telah mendapatkan lisensi dari Badan Nasional Sertifikasi Profesi (BNSP). LSP PAMI didirikan oleh asosiasi profesi di bidang pasar modal dan didukung oleh asosiasi industri pasar modal.
                                    </p>
                                    
                                    <p class="text-justify text-muted">
                                        LSP PAMI merupakan lembaga sertifikasi profesi pertama yang menyelenggarakan Uji Kompetensi di bidang Pasar Modal di Indonesia.
                                    </p>
                                    
                                    <p class="text-justify text-muted">
                                        Industri pasar modal membutuhkan tenaga kerja profesional yang berkualitas, kredibel, dan kompeten, yang dapat dibuktikan serta diakui melalui Sertifikasi Profesi di bidang Pasar Modal. Sertifikasi ini diselenggarakan oleh LSP PAMI bagi para profesional maupun calon profesional, dan merupakan sertifikasi tingkat nasional yang mengacu pada Standar Kompetensi Kerja Nasional Indonesia (SKKNI) yang telah terdaftar di Kementerian Ketenagakerjaan Republik Indonesia (No. Kep.317/LATTAS/XII/2014).
                                    </p>
                                    
                                    <p class="text-justify text-muted">
                                        Pasar modal memiliki sejumlah profesi yang mengharuskan kepemilikan lisensi dari OJK, seperti WPPE (Wakil Perantara Pedagang Efek), WPEE (Wakil Penjamin Emisi Efek), WMI (Wakil Manajer Investasi), dan ASPM (Ahli Syariah Pasar Modal). Kepemilikan lisensi ini merupakan kewajiban bagi para profesional di bidang tersebut.
                                    </p>
                                    
                                    <p class="text-justify text-muted">
                                        Namun, kebutuhan tenaga profesional di industri pasar modal terus berkembang. Spesialisasi pekerjaan menuntut individu untuk memiliki kompetensi tertentu yang dibutuhkan dalam pekerjaan-pekerjaan yang semakin spesifik dan tidak umum.
                                    </p>
                                    
                                    <p class="text-justify text-muted">
                                        Di sisi lain, seluruh industri di Indonesia pada akhirnya akan mengacu pada penyeragaman kompetensi melalui sertifikasi yang diselenggarakan oleh lembaga resmi yang dibentuk pemerintah, yaitu Badan Nasional Sertifikasi Profesi (BNSP). Hal inilah yang menjadi latar belakang pendirian Lembaga Sertifikasi Pengembangan Manajemen Indonesia (LSP PAMI).
                                    </p>
                                    
                                    <ul>
                                        <li>Analis Efek</li>
                                        <li>Analis Teknikal</li>
                                        <li>Manajemen Risiko</li>
                                        <li>Investment Banking</li>
                                        <li>Keputusan</li>
                                        <li>Perdagangan Efek</li>
                                        <li>Analis Pendapatan Tetap</li>
                                    </ul>' !!}
            </div>
        </div>

        {{-- Section Tambahan Dinamis dari Database --}}
        <div class="row">
            <div class="col-md-4 mb-4">
                @php
                    // Cek apakah ada sections dari database
                    $dbSections = $sections ?? collect();
                    $hasDbSections = false;

                    if (!empty($dbSections)) {
                        foreach ($dbSections as $section) {
                            if (is_object($section) && isset($section->key) && isset($section->title)) {
                                $hasDbSections = true;
                                break;
                            }
                        }
                    }

                    // Fallback sections jika tidak ada data dari database
                    $fallbackSections = [
                        'mengapa' => 'Mengapa Harus Sertifikasi LSP Pasar Modal',
                        'visi' => 'Visi dan Misi',
                        'tujuan' => 'Maksud dan Tujuan',
                        'manfaat-masyarakat' => 'Manfaat Bagi Pemerintah dan Masyarakat',
                        'manfaat-perusahaan' => 'Manfaat Bagi Perusahaan',
                        'manfaat-tenaga-kerja' => 'Manfaat Bagi Tenaga Kerja',
                    ];
                @endphp

                <div class="card shadow-sm border-0">
                    <div class="card-header btn-primary text-white fw-semibold">
                        Informasi LSP PAMI
                    </div>
                    <div class="list-group list-group-flush">
                        @if ($hasDbSections)
                            {{-- Tampilkan sections dari database --}}
                            @foreach ($dbSections as $section)
                                @if (is_object($section) && isset($section->key) && isset($section->title))
                                    <button type="button"
                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center section-toggle {{ $loop->first ? 'active bg-warning text-dark border-warning' : '' }}"
                                        data-target="{{ $section->key }}">
                                        <span>{{ $section->title }}</span>
                                        <i class="bi bi-chevron-right ms-2 text-muted small"></i>
                                    </button>
                                @endif
                            @endforeach
                        @else
                            {{-- Tampilkan fallback sections --}}
                            @foreach ($fallbackSections as $key => $title)
                                <button type="button"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center section-toggle {{ $loop->first ? 'active bg-warning text-dark border-warning' : '' }}"
                                    data-target="{{ $key }}">
                                    <span>{{ $title }}</span>
                                    <i class="bi bi-chevron-right ms-2 text-muted small"></i>
                                </button>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="bg-light p-4 rounded shadow-sm">
                    @if (isset($error))
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle"></i> {{ $error }}
                        </div>
                    @endif

                    @if ($hasDbSections)
                        {{-- Tampilkan content dari database --}}
                        @foreach ($dbSections as $index => $section)
                            @if (is_object($section) && isset($section->key) && isset($section->title))
                                <div class="section-content" id="content-{{ $section->key }}"
                                    style="{{ $index === 0 ? '' : 'display:none;' }}">

                                    <div class="section-body">
                                        {!! $section->content ?? '<p class="text-muted">Konten belum tersedia.</p>' !!}
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        {{-- Fallback content jika tidak ada data di database --}}
                        <div class="section-content" id="content-mengapa" style="">
                            <h3 class="h5 fw-semibold mb-3">Mengapa Harus Sertifikasi di LSP PAMI?</h3>
                            <ol class="ps-3">
                                <li>Lembaga Sertifikasi Pertama di Bidang Pasar Modal</li>
                                <li>Diakui oleh SKKNI Pasar Modal dan SKK Pasar Modal</li>
                                <li>Lebih dari 6000 Peserta Kompeten</li>
                                <li>Telah bekerjasama dengan 50+ Kampus, 10+ Lembaga Pelatihan, 10+ Asosiasi Profesi</li>
                                <li>Memiliki Izin Asesmen Jarak Jauh dari BNSP</li>
                                <li>Didirikan dan Didukung oleh Asosiasi di Pasar Modal</li>
                            </ol>
                        </div>

                        <div class="section-content" id="content-visi" style="display:none;">
                            <h3 class="h5 fw-semibold mb-3">Visi dan Misi</h3>
                            <p class="text-muted">Visi LSP PAMI adalah menjadi lembaga terpercaya dalam sertifikasi profesi
                                pasar modal di Indonesia.</p>
                        </div>

                        <div class="section-content" id="content-tujuan" style="display:none;">
                            <h3 class="h5 fw-semibold mb-3">Maksud dan Tujuan</h3>
                            <p class="text-muted">Tujuan utama adalah menyediakan tenaga kerja kompeten di bidang pasar
                                modal.</p>
                        </div>

                        <div class="section-content" id="content-manfaat-masyarakat" style="display:none;">
                            <h3 class="h5 fw-semibold mb-3">Manfaat Bagi Pemerintah dan Masyarakat</h3>
                            <p class="text-muted">Menjamin kualitas SDM yang kredibel dan kompeten di sektor pasar modal.
                            </p>
                        </div>

                        <div class="section-content" id="content-manfaat-perusahaan" style="display:none;">
                            <h3 class="h5 fw-semibold mb-3">Manfaat Bagi Perusahaan</h3>
                            <p class="text-muted">Mempermudah perekrutan dan validasi kualifikasi profesional karyawan.</p>
                        </div>

                        <div class="section-content" id="content-manfaat-tenaga-kerja" style="display:none;">
                            <h3 class="h5 fw-semibold mb-3">Manfaat Bagi Tenaga Kerja</h3>
                            <p class="text-muted">Meningkatkan daya saing dan pengakuan profesionalisme di industri pasar
                                modal.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.section-toggle').forEach(button => {
            button.addEventListener('click', function() {
                const target = this.dataset.target;

                // Reset all buttons
                document.querySelectorAll('.section-toggle').forEach(btn => {
                    btn.classList.remove('active', 'bg-warning', 'text-dark', 'border-warning');
                });
                this.classList.add('active', 'bg-warning', 'text-dark', 'border-warning');

                // Hide all contents
                document.querySelectorAll('.section-content').forEach(content => {
                    content.style.display = 'none';
                });

                // Show selected content
                const contentToShow = document.getElementById('content-' + target);
                if (contentToShow) {
                    contentToShow.style.display = 'block';
                }
            });
        });
    </script>
@endpush
