{{-- resources/views/Backend/beranda/certification/form.blade.php --}}
<div class="row">
    <div class="col-md-8">
        {{-- Certification Title --}}
        <div class="mb-3">
            <label for="title" class="form-label">Certification Title <span class="text-danger">*</span></label>
            <input type="text" 
                   class="form-control @error('title') is-invalid @enderror" 
                   id="title" 
                   name="title" 
                   value="{{ old('title', $certification->title ?? '') }}" 
                   placeholder="Enter certification scheme title"
                   required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Certification Description --}}
        <div class="mb-3">
            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
            <textarea class="form-control @error('description') is-invalid @enderror" 
                      id="description" 
                      name="description" 
                      rows="4" 
                      placeholder="Enter detailed description of the certification scheme"
                      required>{{ old('description', $certification->description ?? '') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Button URL --}}
        <div class="mb-3">
            <label for="url" class="form-label">Button URL</label>
            <input type="url" 
                   class="form-control @error('url') is-invalid @enderror" 
                   id="url" 
                   name="url" 
                   value="{{ old('url', $certification->url ?? '') }}" 
                   placeholder="https://example.com">
            @error('url')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Optional: Link for more information about this certification</div>
        </div>

        {{-- Button Text --}}
        <div class="mb-3">
            <label for="button" class="form-label">Button Text</label>
            <input type="text" 
                   class="form-control @error('button') is-invalid @enderror" 
                   id="button" 
                   name="button" 
                   value="{{ old('button', $certification->button ?? '') }}" 
                   placeholder="Learn More">
            @error('button')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Optional: Text to display on the action button</div>
        </div>
    </div>

    <div class="col-md-4">
        {{-- Certification Icon --}}
        <div class="mb-3">
            <label for="icon" class="form-label">
                Certification Icon 
                @if(!isset($certification))
                    <span class="text-danger">*</span>
                @endif
            </label>
            <input type="file" 
                   class="form-control @error('icon') is-invalid @enderror" 
                   id="icon" 
                   name="icon" 
                   accept="image/jpeg,image/png,image/jpg,image/svg,image/webp"
                   onchange="previewIcon(event)"
                   {{ !isset($certification) ? 'required' : '' }}>
            @error('icon')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Supported: JPEG, PNG, JPG, SVG, WebP (Max: 2MB)</div>
        </div>

        {{-- Current Icon Preview --}}
        @if(isset($certification) && $certification->icon)
            <div class="mb-3">
                <label class="form-label">Current Icon</label>
                <div class="border rounded p-3 text-center bg-light">
                    <img src="{{ asset($certification->icon) }}" 
                         alt="Current Icon" 
                         class="img-fluid" 
                         style="max-height: 120px; object-fit: contain;">
                </div>
                <div class="form-text">Leave icon field empty to keep current icon</div>
            </div>
        @endif

        {{-- Icon Preview Area --}}
        <div class="mb-3" id="iconPreview" style="display: none;">
            <label class="form-label">Icon Preview</label>
            <div class="border rounded p-3 text-center bg-light">
                <img id="icon-preview" 
                     alt="Icon Preview" 
                     class="img-fluid" 
                     style="max-height: 120px; object-fit: contain;">
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const iconInput = document.getElementById('icon');
    const previewContainer = document.getElementById('iconPreview');
    const previewImage = document.getElementById('icon-preview');

    // Global function for backward compatibility
    window.previewIcon = function(event) {
        const file = event.target.files[0];
        
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
    };

    // Modern event listener approach
    if (iconInput) {
        iconInput.addEventListener('change', window.previewIcon);
    }
});
</script>
@endpush