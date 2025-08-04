@extends('layouts.admin')

@section('content')
    <div class="container-fluid mt-4">
        @include('partials.alert')

        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="mb-1">
                            <i class="fas fa-list-ul me-2 text-success"></i>
                            Unit Kompetensi
                        </h4>
                        {{-- <p class="text-muted mb-0">
                            Kelola unit kompetensi untuk: <strong>{{ $sertifikasi->title }}</strong>
                            @if ($sertifikasi->parent)
                                <span class="badge bg-info ms-2">{{ $sertifikasi->parent->title }}</span>
                            @endif
                        </p> --}}
                    </div>
                    <div class="btn-group gap-2">
                        @if ($sertifikasi->parent_id)
                            <a href="{{ route('admin.sertifikasi.persyaratan-dasar', $sertifikasi) }}"
                                class="btn btn-outline-primary rounded">
                                <i class="fas fa-file-alt me-2"></i>Persyaratan Dasar
                            </a>
                            <a href="{{ route('admin.sertifikasi.biaya-uji', $sertifikasi) }}"
                                class="btn btn-outline-info rounded">
                                <i class="fas fa-money-bill-wave me-2"></i>Biaya Uji Kompetensi
                            </a>
                        @endif
                        <a href="{{ route('admin.sertifikasi.index') }}" class="btn btn-outline-secondary rounded">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-edit me-2"></i>Editor Unit Kompetensi</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.sertifikasi.unit-kompetensi.update', $sertifikasi) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="editor" class="form-label">Konten Unit Kompetensi</label>
                                <textarea id="editor" name="content" class="form-control @error('content') is-invalid @enderror" rows="15">{{ old('content', $unit->content ?? '') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <div class="text-muted small">
                                    Terakhir diupdate:
                                    @if ($unit && $unit->updated_at)
                                        {{ $unit->updated_at->format('d/m/Y H:i') }}
                                    @else
                                        Belum pernah diupdate
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-success rounded">
                                    <i class="fas fa-save me-2"></i>Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Quick Templates -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-magic me-2"></i>Template Cepat</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <button type="button" class="btn btn-outline-primary w-100 rounded"
                                    onclick="insertTemplate('basic')">
                                    <i class="fas fa-list me-2"></i>Template Dasar
                                </button>
                            </div>
                            <div class="col-md-4 mb-2">
                                <button type="button" class="btn btn-outline-success w-100 rounded"
                                    onclick="insertTemplate('detailed')">
                                    <i class="fas fa-list-ol me-2"></i>Template Detail
                                </button>
                            </div>
                            <div class="col-md-4 mb-2">
                                <button type="button" class="btn btn-outline-info w-100 rounded"
                                    onclick="insertTemplate('table')">
                                    <i class="fas fa-table me-2"></i>Template Tabel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function insertTemplate(type) {
            let template = '';

            switch (type) {
                case 'basic':
                    template = `<h3>Unit Kompetensi</h3>
<ul>
    <li><strong>Kode Unit:</strong> [Masukkan kode unit]</li>
    <li><strong>Judul Unit:</strong> [Masukkan judul unit]</li>
    <li><strong>Deskripsi Unit:</strong> [Masukkan deskripsi unit]</li>
</ul>

<h4>Elemen Kompetensi</h4>
<ol>
    <li>[Elemen kompetensi 1]</li>
    <li>[Elemen kompetensi 2]</li>
    <li>[Elemen kompetensi 3]</li>
</ol>`;
                    break;

                case 'detailed':
                    template = `<h2>UNIT KOMPETENSI</h2>
<table border="1" style="width: 100%;">
    <tr>
        <td><strong>Kode Unit</strong></td>
        <td>[Masukkan Kode Unit]</td>
    </tr>
    <tr>
        <td><strong>Judul Unit</strong></td>
        <td>[Masukkan Judul Unit]</td>
    </tr>
</table>

<h3>ELEMEN KOMPETENSI</h3>
<table border="1" style="width: 100%;">
    <thead>
        <tr>
            <th>Elemen</th>
            <th>Kriteria Unjuk Kerja</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>[Elemen 1]</td>
            <td>[Kriteria 1]</td>
        </tr>
    </tbody>
</table>`;
                    break;

                case 'table':
                    template = `<h3>Daftar Unit Kompetensi</h3>
<table border="1" style="width: 100%;">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Unit</th>
            <th>Judul Unit</th>
            <th>Jenis</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>[Kode Unit 1]</td>
            <td>[Judul Unit 1]</td>
            <td>[Inti/Pilihan]</td>
        </tr>
    </tbody>
</table>`;
                    break;
            }

            // Assuming TinyMCE is used with id="editor"
            if (typeof tinymce !== 'undefined') {
                tinymce.get('editor').setContent(template);
            } else {
                document.getElementById('editor').value = template;
            }
        }
    </script>
@endsection
