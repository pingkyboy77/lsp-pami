<div class="card-body p-3">
    <div class="mb-3">
        <label for="nama" class="form-label">Name</label>
        <input type="text" name="nama" value="{{ old('nama', $pesertaSertifikat->nama ?? '') }}" class="form-control" required>
    </div>


    @foreach ([
        'sertifikasi' => 'Skema Sertifiaksi',
        'no_ser' => 'No SER',
        'no_reg' => 'No Reg',
        'no_sertifikat' => 'No Sertifikat',
        'tanggal_terbit' => 'Tanggal Terbit',
        'tanggal_exp' => 'Tanggal Exp',
        'registrasi_nomor' => 'Registrasi Nomor',
        'tahun_registrasi' => 'Tahun Registrasi',
        'nomor_blanko' => 'Nomor Blanko',
    ] as $field => $label)
        <div class="mb-3">
            <label for="{{ $field }}" class="form-label">{{ $label }}</label>
            <input type="{{ str_contains($field, 'tanggal') ? 'date' : 'text' }}" name="{{ $field }}" value="{{ old($field, $pesertaSertifikat->$field ?? '') }}" class="form-control">
        </div>
    @endforeach

    
</div>
