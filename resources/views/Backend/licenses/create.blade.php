@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="card rounded-4 shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bi bi-plus-circle"></i> Add New License
                </h4>
            </div>
            <div class="card-body">
                @include('partials.alert')

                <form action="{{ route('admin.licenses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" 
                                       class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Subtitle</label>
                                <input type="text" name="subtitle" 
                                       class="form-control @error('subtitle') is-invalid @enderror"
                                       value="{{ old('subtitle') }}">
                                @error('subtitle')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description 1</label>
                                <textarea name="desc1" 
                                          class="form-control @error('desc1') is-invalid @enderror" 
                                          rows="3">{{ old('desc1') }}</textarea>
                                @error('desc1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description 2</label>
                                <textarea name="desc2" 
                                          class="form-control @error('desc2') is-invalid @enderror" 
                                          rows="3">{{ old('desc2') }}</textarea>
                                @error('desc2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">License Image <span class="text-danger">*</span></label>
                                <input type="file" name="image" 
                                       class="form-control @error('image') is-invalid @enderror"
                                       accept="image/jpeg,image/png,image/jpg,image/webp"
                                       onchange="previewImage(event, 'license-preview')" required>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Supported: JPEG, PNG, JPG, WebP (Max: 5MB)</div>

                                <!-- Image Preview -->
                                <div class="mt-3" id="licensePreview" style="display: none;">
                                    <label class="form-label">Image Preview</label>
                                    <div class="border rounded p-3 text-center bg-light">
                                        <img id="license-preview" alt="Image Preview" class="img-fluid"
                                            style="max-height: 200px; object-fit: contain;">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Order <span class="text-danger">*</span></label>
                                <input type="number" name="order" 
                                       class="form-control @error('order') is-invalid @enderror"
                                       value="{{ old('order', 1) }}" min="1" required>
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Order for display sequence</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="">Select Status</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end align-items-center gap-2 mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-lg"></i> Save License
                        </button>
                        <a href="{{ route('admin.licenses.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back to List
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
            const previewContainer = document.getElementById('licensePreview');
            const previewImage = document.getElementById(previewId);

            if (file) {
                // Validate file type
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPEG, PNG, JPG, WebP)');
                    event.target.value = '';
                    previewContainer.style.display = 'none';
                    return;
                }

                // Validate file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('File size must be less than 5MB');
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