@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-4">
    @include('partials.alert')
    
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">
                        <i class="fas fa-file-alt me-2 text-primary"></i>
                        Persyaratan Dasar
                    </h4>
                    {{-- <p class="text-muted mb-0">
                        Kelola persyaratan dasar untuk: <strong>{{ $sertifikasi->title }}</strong>
                        @if($sertifikasi->parent)
                            <span class="badge bg-info ms-2">{{ $sertifikasi->parent->title }}</span>
                        @endif
                    </p> --}}
                </div>
                <div class="btn-group gap-2">
                    <a href="{{ route('admin.sertifikasi.unit-kompetensi', $sertifikasi) }}" class="btn btn-outline-success rounded">
                        <i class="fas fa-list-ul me-2"></i>Unit Kompetensi
                    </a>
                    <a href="{{ route('admin.sertifikasi.biaya-uji', $sertifikasi) }}" class="btn btn-outline-info rounded">
                        <i class="fas fa-money-bill-wave me-2"></i>Biaya Uji Kompetensi
                    </a>
                    <a href="{{ route('admin.sertifikasi.index') }}" class="btn btn-outline-secondary rounded">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-edit me-2"></i>Editor Persyaratan Dasar</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.sertifikasi.persyaratan-dasar.update', $sertifikasi) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="editor" class="form-label">Konten Persyaratan Dasar</label>
                            <textarea id="editor" name="content" class="form-control @error('content') is-invalid @enderror" rows="15">{{ old('content', $persyaratanDasar->content ?? '') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <div class="text-muted small">
                                Terakhir diupdate: 
                                @if($persyaratanDasar && $persyaratanDasar->updated_at)
                                    {{ $persyaratanDasar->updated_at->format('d/m/Y H:i') }}
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
                            <button type="button" class="btn btn-outline-primary w-100 rounded" onclick="insertTemplate('basic')">
                                <i class="fas fa-list me-2"></i>Template Dasar
                            </button>
                        </div>
                        <div class="col-md-4 mb-2">
                            <button type="button" class="btn btn-outline-success w-100 rounded" onclick="insertTemplate('detailed')">
                                <i class="fas fa-list-ol me-2"></i>Template Detail
                            </button>
                        </div>
                        <div class="col-md-4 mb-2">
                            <button type="button" class="btn btn-outline-info w-100 rounded" onclick="insertTemplate('table')">
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
    
    switch(type) {
        case 'basic':
            template = `<h3>Persyaratan Dasar</h3>
<h4>A. Persyaratan Pendidikan</h4>
<ul>
    <li>[Minimum pendidikan yang diperlukan]</li>
    <li>[Jurusan atau bidang studi yang relevan]</li>
</ul>

<h4>B. Persyaratan Pengalaman</h4>
<ul>
    <li>[Pengalaman kerja minimum]</li>
    <li>[Jenis pengalaman yang relevan]</li>
</ul>

<h4>C. Persyaratan Administrasi</h4>
<ul>
    <li>Fotokopi KTP yang masih berlaku</li>
    <li>Pas foto terbaru ukuran 3x4 (2 lembar)</li>
    <li>Fotokopi ijazah terakhir</li>
    <li>CV terbaru</li>
</ul>`;
            break;
            
        case 'detailed':
            template = `<h2>PERSYARATAN DASAR UJI KOMPETENSI</h2>

<h3>1. PERSYARATAN UMUM</h3>
<table border="1" style="width: 100%;">
    <tr>
        <td width="30%"><strong>Usia</strong></td>
        <td>[Batasan usia peserta]</td>
    </tr>
    <tr>
        <td><strong>Pendidikan</strong></td>
        <td>[Minimum pendidikan]</td>
    </tr>
    <tr>
        <td><strong>Pengalaman</strong></td>
        <td>[Pengalaman yang diperlukan]</td>
    </tr>
</table>

<h3>2. DOKUMEN YANG DIPERLUKAN</h3>
<ol>
    <li>Formulir pendaftaran yang telah diisi lengkap</li>
    <li>Fotokopi KTP yang masih berlaku</li>
    <li>Pas foto terbaru ukuran 3x4 (3 lembar)</li>
    <li>Fotokopi ijazah pendidikan terakhir</li>
    <li>Surat keterangan pengalaman kerja</li>
    <li>Sertifikat pelatihan yang relevan (jika ada)</li>
</ol>

<h3>3. PERSYARATAN KHUSUS</h3>
<ul>
    <li>[Persyaratan khusus sesuai bidang kompetensi]</li>
    <li>[Kondisi fisik atau mental tertentu]</li>
    <li>[Peralatan atau perlengkapan khusus]</li>
</ul>`;
            break;
            
        case 'table':
            template = `<h3>Checklist Persyaratan Dasar</h3>
<table border="1" style="width: 100%;">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="40%">Persyaratan</th>
            <th width="25%">Keterangan</th>
            <th width="15%">Wajib/Opsional</th>
            <th width="15%">Status</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Fotokopi KTP</td>
            <td>Yang masih berlaku</td>
            <td>Wajib</td>
            <td>☐</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Pas Foto</td>
            <td>3x4 sebanyak 3 lembar</td>
            <td>Wajib</td>
            <td>☐</td>
        </tr>
        <tr>
            <td>3</td>
            <td>Fotokopi Ijazah</td>
            <td>Pendidikan terakhir</td>
            <td>Wajib</td>
            <td>☐</td>
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