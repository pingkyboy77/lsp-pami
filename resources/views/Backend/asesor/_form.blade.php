<div class="card-body p-3">
    <div class="mb-3">
        <label for="nama" class="form-label">Name</label>
        <input type="text" name="nama" value="{{ old('nama', $asesor->nama ?? '') }}" class="form-control" required>
    </div>


    @foreach ([
        'nomor_met' => 'Nomor MET',
    ] as $field => $label)
        <div class="mb-3">
            <label for="{{ $field }}" class="form-label">{{ $label }}</label>
            <input type="{{ str_contains($field, 'tanggal') ? 'date' : 'text' }}" name="{{ $field }}" value="{{ old($field, $asesor->$field ?? '') }}" class="form-control">
        </div>
    @endforeach

    
</div>
