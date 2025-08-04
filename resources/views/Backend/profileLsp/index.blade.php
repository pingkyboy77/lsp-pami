@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="card rounded-4 shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bi bi-building"></i> Manage LSP Profile
                </h4>
            </div>
            <div class="card-body">
                @include('partials.alert')

                <form action="{{ route('admin.lsp.update', $profile->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $profile->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        @if ($profile->image)
                            <div class="mb-2">
                                <label class="form-label">Current Image</label>
                                <div class="border rounded p-3 text-center bg-light">
                                    <img src="{{ asset($profile->image) }}" alt="Current Image" class="img-fluid"
                                        style="max-height: 150px; object-fit: contain;">
                                </div>
                                <div class="form-text">Leave image field empty to keep current image</div>
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                            accept="image/jpeg,image/png,image/jpg,image/svg,image/webp"
                            onchange="previewImage(event, 'profile-preview')">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Supported: JPEG, PNG, JPG, SVG, WebP (Max: 2MB)</div>

                        <!-- Image Preview -->
                        <div class="mt-2" id="profilePreview" style="display: none;">
                            <label class="form-label">Image Preview</label>
                            <div class="border rounded p-3 text-center bg-light">
                                <img id="profile-preview" alt="Image Preview" class="img-fluid"
                                    style="max-height: 150px; object-fit: contain;">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea name="content" id="editor" class="form-control @error('content') is-invalid @enderror" rows="10"
                            required>{{ old('content', $profile->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">You can use HTML tags for formatting</div>
                    </div>

                    <div class="d-flex justify-content-end align-items-center gap-2">
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
            const previewContainer = document.getElementById('profilePreview');
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

        // Initialize rich text editor if needed
        // You can uncomment and configure this based on your editor choice
        /*
        document.addEventListener('DOMContentLoaded', function() {
            // Example with CKEditor
            ClassicEditor
                .create(document.querySelector('#editor'))
                .catch(error => {
                    console.error(error);
                });
        });
        */
    </script>
@endpush
