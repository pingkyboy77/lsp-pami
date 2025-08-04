@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- <div class="btn-primary text-white rounded px-4 py-3 shadow-sm mb-4 d-grid"> --}}
        {{-- <h2 class="fw-bold text-primary-emphasis"></h2> --}}
        <h2 class="modern-title">Manajemen Pengguna</h2>
        <hr class="modern-hr">
        <p class="text-black mb-4 text-center">Aplikasi ini mengatur hak akses sesuai kewenangan yang telah ditetapkan oleh LSP.</p>
    {{-- </div> --}}

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle shadow-sm">
            <thead class="table-light">
                <tr class="text-center">
                    <th style="width: 50px;">No</th>
                    <th>Akun</th>
                    <th>Role</th>
                    <th>Akses</th>
                </tr>
            </thead>
            <tbody>
                @php $users = [
                    ['Akun' => 'Super Admin', 'Role' => 'Administrator', 'Akses' => 'Semua dokumen'],
                    ['Akun' => 'Admin LSP PAMI', 'Role' => 'Mengelola Sistem Sertifikasi<br>Jarak Jauh', 'Akses' => 'Pendaftaran s.d Keputusan'],
                    ['Akun' => 'Manajer Sertifikasi', 'Role' => 'Pengawasan', 'Akses' => 'Pendaftaran s.d Keputusan'],
                    ['Akun' => 'Direktur', 'Role' => 'Pengawasan', 'Akses' => 'Pendaftaran s.d Keputusan'],
                    ['Akun' => 'Verifikator TUK', 'Role' => 'Memverifikasi TUK', 'Akses' => 'Verifikasi TUK'],
                    ['Akun' => 'Observer Asesmen', 'Role' => 'Mendampingi asesmen', 'Akses' => 'Pelaksanaan'],
                    ['Akun' => 'Asesor Kompetensi', 'Role' => 'Melaksanakan asesmen', 'Akses' => 'Konsultasi & Pelaksanaan Asesmen'],
                    ['Akun' => 'Asesi', 'Role' => 'Mengikuti sertifikasi', 'Akses' => 'Pendaftaran s.d Keputusan'],
                    ['Akun' => 'Tim Teknis', 'Role' => 'Memutuskan hasil sertifikasi', 'Akses' => 'Keputusan Sertifikasi'],
                    ['Akun' => 'Master Asesor', 'Role' => 'Memvalidasi Materi Uji Kompetensi, Meninjau Materi Uji Kompetensi, Meninjau Proses Asesmen, Memberikan Kontribusi dalam Validasi Asesmen', 'Akses' => 'Perencanaan Asesmen, Perangkat Asesmen, Rekaman Asesmen'],
                    ['Akun' => 'Komite Ketidakberpihakan', 'Role' => 'Menangani Banding', 'Akses' => 'Banding'],
                ]; @endphp

                @foreach($users as $i => $user)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>{{ $user['Akun'] }}</td>
                        <td>{!! $user['Role'] !!}</td>
                        <td>{!! $user['Akses'] !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- <div class="mt-4 d-flex justify-content-start">
        <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary rounded-pill px-4">← Kembali</a>
    </div> --}}
</div>
@endsection
