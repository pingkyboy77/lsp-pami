{{-- resources/views/Backend/beranda/services/form.blade.php --}}
<div class="row">
    <div class="col-md-8">
        {{-- Service Title --}}
        <div class="mb-3">
            <label for="title" class="form-label">Service Title <span class="text-danger">*</span></label>
            <input type="text" 
                   class="form-control @error('title') is-invalid @enderror" 
                   id="title" 
                   name="title" 
                   value="{{ old('title', $service->title ?? '') }}" 
                   placeholder="Enter service title"
                   required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Service URL --}}
        <div class="mb-3">
            <label for="url" class="form-label">Service URL</label>
            <input type="url" 
                   class="form-control @error('url') is-invalid @enderror" 
                   id="url" 
                   name="url" 
                   value="{{ old('url', $service->url ?? '') }}" 
                   placeholder="https://example.com">
            @error('url')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Optional: Link to service details or external page</div>
        </div>
    </div>

    <div class="col-md-4">
        {{-- Service Icon --}}
        <div class="mb-3">
            <label for="icon" class="form-label">Service Icon</label>
            <input type="file" 
                   class="form-control @error('icon') is-invalid @enderror" 
                   id="icon" 
                   name="icon" 
                   accept="image/jpeg,image/png,image/jpg,image/svg,image/webp">
            @error('icon')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Supported: JPEG, PNG, JPG, SVG, WebP (Max: 2MB)</div>
        </div>

        {{-- Current Icon Preview --}}
        @if(isset($service) && $service->icon)
            <div class="mb-3">
                <label class="form-label">Current Icon</label>
                <div class="border rounded p-3 text-center bg-light">
                    <img src="{{ asset($service->icon) }}" 
                         alt="Current Icon" 
                         class="img-fluid" 
                         style="max-height: 100px; object-fit: contain;">
                </div>
                <div class="form-text">Leave icon field empty to keep current icon</div>
            </div>
        @endif

        {{-- Icon Preview Area --}}
        <div class="mb-3" id="iconPreview" style="display: none;">
            <label class="form-label">Icon Preview</label>
            <div class="border rounded p-3 text-center bg-light">
                <img id="previewImage" 
                     alt="Icon Preview" 
                     class="img-fluid" 
                     style="max-height: 100px; object-fit: contain;">
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const iconInput = document.getElementById('icon');
    const previewContainer = document.getElementById('iconPreview');
    const previewImage = document.getElementById('previewImage');

    iconInput.addEventListener('change', function(e) {
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