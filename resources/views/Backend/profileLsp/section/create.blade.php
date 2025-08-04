@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-plus-circle"></i> Tambah Section Baru
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.lsp.sections.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="key" class="form-label">Key <span class="text-danger">*</span></label>
                            <input type="text" readonly
                                   name="key" 
                                   id="key" 
                                   class="form-control @error('key') is-invalid @enderror" 
                                   value="{{ old('key') }}" 
                                   required>
                            <div class="form-text">Otomatis Di isi saat membuat judul</div>
                            @error('key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title') }}" 
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Konten</label>
                            <textarea name="content" 
                                      id="editor" 
                                      class="form-control @error('content') is-invalid @enderror" 
                                      rows="10">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="order" class="form-label">Urutan</label>
                            <input type="number" 
                                   name="order" 
                                   id="order" 
                                   class="form-control @error('order') is-invalid @enderror" 
                                   value="{{ old('order') }}" 
                                   placeholder="Kosongkan untuk urutan otomatis">
                            <div class="form-text">Jika dikosongkan, akan diletakkan di urutan terakhir</div>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.lsp.sections.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Save Section
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>

// Auto-generate key from title
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const key = title.toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
                    .replace(/\s+/g, '-') // Replace spaces with hyphens
                    .replace(/-+/g, '-') // Replace multiple hyphens with single
                    .replace(/^-|-$/g, ''); // Remove leading/trailing hyphens
    
    document.getElementById('key').value = key;
});
</script>
@endpush