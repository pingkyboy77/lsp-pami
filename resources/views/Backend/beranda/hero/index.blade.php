@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bx bx-image"></i> Hero Section
                </h4>
            </div>
            <div class="card-body">
                @include('partials.alert')

                <form action="{{ route('admin.home.hero.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $hero->title) }}" 
                               class="form-control @error('title') is-invalid @enderror" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Highlight</label>
                        <input type="text" name="highlight" value="{{ old('highlight', $hero->highlight) }}"
                               class="form-control @error('highlight') is-invalid @enderror">
                        @error('highlight')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="4" required>{{ old('description', $hero->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gambar</label>
                        @if ($hero->image)
                            <div class="mb-2">
                                <label class="form-label">Current Image</label>
                                <div class="border rounded p-3 text-center bg-light">
                                    <img src="{{ asset($hero->image) }}" alt="Current Image" 
                                         class="img-fluid" style="max-height: 120px; object-fit: contain;">
                                </div>
                                <div class="form-text">Leave image field empty to keep current image</div>
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                               accept="image/jpeg,image/png,image/jpg,image/svg,image/webp"
                               onchange="previewImage(event, 'image-preview')">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Supported: JPEG, PNG, JPG, SVG, WebP (Max: 2MB)</div>
                        
                        <!-- Image Preview -->
                        <div class="mt-2" id="imagePreview" style="display: none;">
                            <label class="form-label">Image Preview</label>
                            <div class="border rounded p-3 text-center bg-light">
                                <img id="image-preview" alt="Image Preview" 
                                     class="img-fluid" style="max-height: 120px; object-fit: contain;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">CTA 1 - Text</label>
                            <input type="text" name="cta_1[text]" value="{{ $hero->cta_1['text'] ?? '' }}"
                                   class="form-control @error('cta_1.text') is-invalid @enderror">
                            @error('cta_1.text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">CTA 1 - Link</label>
                            <input type="url" name="cta_1[link]" value="{{ $hero->cta_1['link'] ?? '' }}"
                                   class="form-control @error('cta_1.link') is-invalid @enderror"
                                   placeholder="https://example.com">
                            @error('cta_1.link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">CTA 1 - Icon</label>
                            <input type="text" name="cta_1[icon]" value="{{ $hero->cta_1['icon'] ?? '' }}"
                                   class="form-control @error('cta_1.icon') is-invalid @enderror" 
                                   placeholder="example: bi bi-award">
                            @error('cta_1.icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">CTA 2 - Text</label>
                            <input type="text" name="cta_2[text]" value="{{ $hero->cta_2['text'] ?? '' }}"
                                   class="form-control @error('cta_2.text') is-invalid @enderror">
                            @error('cta_2.text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">CTA 2 - Link</label>
                            <input type="url" name="cta_2[link]" value="{{ $hero->cta_2['link'] ?? '' }}"
                                   class="form-control @error('cta_2.link') is-invalid @enderror"
                                   placeholder="https://example.com">
                            @error('cta_2.link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">CTA 2 - Icon</label>
                            <input type="text" name="cta_2[icon]" value="{{ $hero->cta_2['icon'] ?? '' }}"
                                   class="form-control @error('cta_2.icon') is-invalid @enderror" 
                                   placeholder="example: bi bi-question-circle">
                            @error('cta_2.icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Badge</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="badge[text]" value="{{ $hero->badge['text'] ?? '' }}"
                                       class="form-control @error('badge.text') is-invalid @enderror" 
                                       placeholder="Teks badge">
                                @error('badge.text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="badge[icon]" value="{{ $hero->badge['icon'] ?? '' }}"
                                       class="form-control @error('badge.icon') is-invalid @enderror" 
                                       placeholder="Icon badge (ex: bi bi-patch-check)">
                                @error('badge.icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Text Note Gambar</label>
                        <input type="text" name="date" value="{{ old('date', $hero->date) }}" 
                               class="form-control @error('date') is-invalid @enderror">
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end mt-3 gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-lg"></i> Save Changes
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function previewImage(event, previewId) {
    const file = event.target.files[0];
    const previewContainer = document.getElementById('imagePreview');
    const previewImage = document.getElementById(previewId);
    
    if (file) {
        // Validate file type
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/svg+xml', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            alert('Please select a valid image file (JPEG, PNG, JPG, SVG, WebP)');
            event.target.value = '';
            previewContainer.style.display = 'none';
            return;
        }

        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB');
            event.target.value = '';
            previewContainer.style.display = 'none';
            return;
        }

        // Show preview
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