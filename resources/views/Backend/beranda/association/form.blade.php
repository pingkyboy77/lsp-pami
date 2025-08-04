{{-- resources/views/Backend/beranda/association/form.blade.php --}}
<div class="row">
    <div class="col-md-8">
        {{-- Association Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Association Name</label>
            <input type="text" 
                   class="form-control @error('name') is-invalid @enderror" 
                   id="name" 
                   name="name" 
                   value="{{ old('name', $association->name ?? '') }}" 
                   placeholder="Enter association name (optional)">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Optional: Name or description for this association</div>
        </div>
    </div>

    <div class="col-md-4">
        {{-- Association Image --}}
        <div class="mb-3">
            <label for="image" class="form-label">Association Logo <span class="text-danger">*</span></label>
            <input type="file" 
                   class="form-control @error('image') is-invalid @enderror" 
                   id="image" 
                   name="image" 
                   accept="image/jpeg,image/png,image/jpg,image/svg,image/webp"
                   {{ !isset($association) ? 'required' : '' }}>
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Supported: JPEG, PNG, JPG, SVG, WebP (Max: 2MB)</div>
        </div>

        {{-- Current Image Preview --}}
        @if(isset($association) && $association->image)
            <div class="mb-3">
                <label class="form-label">Current Logo</label>
                <div class="border rounded p-3 text-center bg-light">
                    <img src="{{ asset($association->image) }}" 
                         alt="Current Logo" 
                         class="img-fluid" 
                         style="max-height: 120px; object-fit: contain;">
                </div>
                <div class="form-text">Leave image field empty to keep current logo</div>
            </div>
        @endif

        {{-- Image Preview Area --}}
        <div class="mb-3" id="imagePreview" style="display: none;">
            <label class="form-label">Logo Preview</label>
            <div class="border rounded p-3 text-center bg-light">
                <img id="previewImage" 
                     alt="Logo Preview" 
                     class="img-fluid" 
                     style="max-height: 120px; object-fit: contain;">
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const previewContainer = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            // Validate file type
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/svg+xml', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                alert('Please select a valid image file (JPEG, PNG, JPG, SVG, WebP)');
                this.value = '';
                previewContainer.style.display = 'none';
                return;
            }

            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB');
                this.value = '';
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
    });
});
</script>
@endpush