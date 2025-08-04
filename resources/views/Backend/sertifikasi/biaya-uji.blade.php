@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-4">
    @include('partials.alert')
    
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">
                        <i class="fas fa-money-bill-wave me-2 text-info"></i>
                        Biaya Uji Kompetensi
                    </h4>
                    {{-- <p class="text-muted mb-0">
                        Kelola biaya uji kompetensi untuk: <strong>{{ $sertifikasi->title }}</strong>
                        @if($sertifikasi->parent)
                            <span class="badge bg-info ms-2">{{ $sertifikasi->parent->title }}</span>
                        @endif
                    </p> --}}
                </div>
                <div class="btn-group gap-2">
                    <a href="{{ route('admin.sertifikasi.unit-kompetensi', $sertifikasi) }}" class="btn btn-outline-success rounded">
                        <i class="fas fa-list-ul me-2"></i>Unit Kompetensi
                    </a>
                    <a href="{{ route('admin.sertifikasi.persyaratan-dasar', $sertifikasi) }}" class="btn btn-outline-primary rounded">
                        <i class="fas fa-file-alt me-2"></i>Persyaratan Dasar
                    </a>
                    <a href="{{ route('admin.sertifikasi.index') }}" class="btn btn-outline-secondary rounded">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-edit me-2"></i>Editor Biaya Uji Kompetensi</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.sertifikasi.biaya-uji.update', $sertifikasi) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="editor" class="form-label">Konten Biaya Uji Kompetensi</label>
                            <textarea id="editor" name="content" class="form-control @error('content') is-invalid @enderror" rows="15">{{ old('content', $biayaUji->content ?? '') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <div class="text-muted small">
                                Terakhir diupdate: 
                                @if($biayaUji && $biayaUji->updated_at)
                                    {{ $biayaUji->updated_at->format('d/m/Y H:i') }}
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
            template = `<h3>Biaya Uji Kompetensi</h3>
<h4>A. Komponen Biaya</h4>
<ul>
    <li><strong>Biaya Pendaftaran:</strong> Rp [jumlah]</li>
    <li><strong>Biaya Asesmen:</strong> Rp [jumlah]</li>
    <li><strong>Biaya Sertifikat:</strong> Rp [jumlah]</li>
    <li><strong>Biaya Administrasi:</strong> Rp [jumlah]</li>
</ul>

<h4>B. Total Biaya</h4>
<p><strong>Total: Rp [total biaya]</strong></p>

<h4>C. Metode Pembayaran</h4>
<ul>
    <li>Transfer Bank</li>
    <li>Tunai</li>
    <li>[Metode lainnya]</li>
</ul>`;
            break;
            
        case 'detailed':
            template = `<h2>STRUKTUR BIAYA UJI KOMPETENSI</h2>

<h3>1. RINCIAN BIAYA</h3>
<table border="1" style="width: 100%;">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="50%">Komponen Biaya</th>
            <th width="20%">Jumlah (Rp)</th>
            <th width="25%">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Biaya Pendaftaran</td>
            <td>[Jumlah]</td>
            <td>Administrasi pendaftaran</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Biaya Asesmen</td>
            <td>[Jumlah]</td>
            <td>Pelaksanaan uji kompetensi</td>
        </tr>
        <tr>
            <td>3</td>
            <td>Biaya Sertifikat</td>
            <td>[Jumlah]</td>
            <td>Penerbitan sertifikat</td>
        </tr>
        <tr>
            <td colspan="2"><strong>TOTAL</strong></td>
            <td><strong>[Total]</strong></td>
            <td><strong>Sudah termasuk PPN</strong></td>
        </tr>
    </tbody>
</table>

<h3>2. KETENTUAN PEMBAYARAN</h3>
<ul>
    <li>Pembayaran dilakukan sebelum pelaksanaan uji kompetensi</li>
    <li>Biaya yang sudah dibayar tidak dapat dikembalikan</li>
    <li>Pembayaran dapat dilakukan melalui transfer bank atau tunai</li>
</ul>

<h3>3. INFORMASI REKENING</h3>
<table border="1" style="width: 100%;">
    <tr>
        <td width="25%"><strong>Nama Bank</strong></td>
        <td>[Nama Bank]</td>
    </tr>
    <tr>
        <td><strong>No. Rekening</strong></td>
        <td>[Nomor Rekening]</td>
    </tr>
    <tr>
        <td><strong>Atas Nama</strong></td>
        <td>[Nama Pemilik Rekening]</td>
    </tr>
</table>`;
            break;
            
        case 'table':
            template = `<h3>Daftar Biaya Uji Kompetensi</h3>
<table border="1" style="width: 100%;">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="30%">Jenis Sertifikasi</th>
            <th width="25%">Biaya Uji (Rp)</th>
            <th width="20%">Biaya Re-Asesmen (Rp)</th>
            <th width="20%">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>[Nama Sertifikasi 1]</td>
            <td>[Biaya 1]</td>
            <td>[Biaya Re-asesmen 1]</td>
            <td>[Keterangan 1]</td>
        </tr>
        <tr>
            <td>2</td>
            <td>[Nama Sertifikasi 2]</td>
            <td>[Biaya 2]</td>
            <td>[Biaya Re-asesmen 2]</td>
            <td>[Keterangan 2]</td>
        </tr>
    </tbody>
</table>

<h4>Catatan:</h4>
<ul>
    <li>Biaya sudah termasuk PPN 11%</li>
    <li>Biaya re-asesmen hanya untuk unit kompetensi yang tidak kompeten</li>
    <li>Pembayaran dilakukan sebelum pelaksanaan uji kompetensi</li>
</ul>`;
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