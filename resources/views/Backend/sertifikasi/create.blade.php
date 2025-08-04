@extends('layouts.admin')

@section('content')
    <div class="container-fluid mt-4">
        @include('partials.alert')

        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">
                        <i class="fas fa-plus me-2 text-success"></i>
                        Tambah {{ $parent_id === 'parent' ? 'Parent' : 'Sub-' }}Sertifikasi
                    </h4>
                    <a href="{{ route('admin.sertifikasi.index') }}" class="btn btn-outline-secondary rounded">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-edit me-2"></i>
                            Form Tambah {{ $parent_id === 'parent' ? 'Parent' : 'Sub-' }}Sertifikasi
                        </h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.sertifikasi.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="{{ $parent_id === 'parent' ? 'col-md-8' : 'col-12' }}">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Judul Sertifikasi <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" value="{{ old('title') }}" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    @if ($parent_id !== 'parent' && count($parents) > 0)
                                        <div class="mb-3">
                                            <label for="parent_id" class="form-label">Parent Sertifikasi <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select @error('parent_id') is-invalid @enderror"
                                                id="parent_id" name="parent_id" required>
                                                <option value="">Pilih Parent Sertifikasi</option>
                                                @foreach ($parents as $parent)
                                                    <option value="{{ $parent->id }}"
                                                        {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                                        {{ $parent->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('parent_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <label for="editor" class="form-label">Deskripsi</label>
                                        <textarea id="editor" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    @if ($parent_id !== 'parent')
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="is_active"
                                                    name="is_active" value="1"
                                                    {{ old('is_active', true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    Status Aktif
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                @if ($parent_id === 'parent')
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Gambar</label>
                                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                                id="image" name="image" accept="image/*"
                                                onchange="previewImage(this)">
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Format: JPG, JPEG, PNG, WEBP. Maksimal 2MB</div>
                                        </div>

                                        <div class="mb-3">
                                            <img id="imagePreview" src="" alt="Preview"
                                                style="display: none; width: 100%; max-height: 200px; object-fit: cover; border-radius: 8px;">
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="is_active"
                                                    name="is_active" value="1"
                                                    {{ old('is_active', true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    Status Aktif
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="reset" class="btn btn-outline-secondary rounded">
                                    <i class="fas fa-undo me-2"></i>Reset
                                </button>
                                <button type="submit" class="btn btn-success rounded">
                                    <i class="fas fa-save me-2"></i>Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        }
    </script>
@endsection
