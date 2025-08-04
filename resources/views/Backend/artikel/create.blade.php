@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="card rounded-4 shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bi bi-plus-lg"></i> Add New Artikel Pelatihan
                </h4>
                <a href="{{ route('admin.artikel.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>
            <div class="card-body">
                @include('partials.alert')

                <form action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Title --}}
                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Image Upload --}}
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" id="imageInput"
                            class="form-control @error('image') is-invalid @enderror"
                            accept="image/jpeg,image/png,image/jpg,image/svg+xml,image/webp" onchange="previewImage(event)">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Supported: JPEG, PNG, JPG, SVG, WebP (Max: 2MB)</div>

                        {{-- Preview --}}
                        <div class="mt-3" id="imagePreviewContainer" style="display: none;">
                            <label class="form-label">Image Preview</label>
                            <div class="border rounded p-3 text-center bg-light">
                                <img id="imagePreview" alt="Image Preview" class="img-fluid"
                                    style="max-height: 200px; object-fit: contain;">
                            </div>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="mb-3">
                        <label class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea name="content" id="editor" class="form-control @error('content') is-invalid @enderror" rows="10">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Active Checkbox --}}
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1"
                                {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                    </div>

                    {{-- Submit Buttons --}}
                    <div class="d-flex justify-content-end gap-3">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-lg"></i> Save Artikel
                        </button>
                        <a href="{{ route('admin.artikel.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('imagePreviewContainer');
            const previewImage = document.getElementById('imagePreview');

            if (file) {
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/svg+xml', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPEG, PNG, JPG, SVG, WebP)');
                    event.target.value = '';
                    previewContainer.style.display = 'none';
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB');
                    event.target.value = '';
                    previewContainer.style.display = 'none';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
            }
        }
    </script>
@endpush
