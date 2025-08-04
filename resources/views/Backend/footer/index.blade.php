@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bi bi-x-diamond"></i> Manage Footer
                </h4>
            </div>
            <div class="card-body">
                @include('partials.alert')

                <form action="{{ route('admin.site.footer.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Logo</label>
                        @if ($footer && $footer->logo)
                            <div class="mb-2">
                                <label class="form-label">Current Logo</label>
                                <div class="border rounded p-3 text-center bg-light">
                                    <img src="{{ asset($footer->logo) }}" alt="Current Logo" 
                                         class="img-fluid" style="max-height: 60px; object-fit: contain;">
                                </div>
                                <div class="form-text">Leave logo field empty to keep current logo</div>
                            </div>
                        @endif
                        <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror"
                               accept="image/jpeg,image/png,image/jpg,image/svg,image/webp"
                               onchange="previewImage(event, 'logo-preview')">
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Supported: JPEG, PNG, JPG, SVG, WebP (Max: 2MB)</div>
                        
                        <!-- Logo Preview -->
                        <div class="mt-2" id="logoPreview" style="display: none;">
                            <label class="form-label">Logo Preview</label>
                            <div class="border rounded p-3 text-center bg-light">
                                <img id="logo-preview" alt="Logo Preview" 
                                     class="img-fluid" style="max-height: 60px; object-fit: contain;">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="3">{{ old('description', $footer->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                   value="{{ old('address', $footer->address) }}">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kota</label>
                            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" 
                                   value="{{ old('city', $footer->city) }}">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone', $footer->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $footer->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Google Maps Embed</label>
                        <textarea name="map_embed" class="form-control @error('map_embed') is-invalid @enderror" 
                                  rows="3" placeholder="<iframe src='...'></iframe>">{{ old('map_embed', $footer->map_embed) }}</textarea>
                        @error('map_embed')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sosial Media</label>
                        <div id="social-links-container">
                            @if (old('socials', $footer->socials ?? []))
                                @foreach (old('socials', $footer->socials ?? []) as $i => $social)
                                    <div class="row mb-2 social-link-row">
                                        <div class="col-md-5">
                                            <input type="url" name="socials[{{ $i }}][url]"
                                                   class="form-control" placeholder="https://facebook.com/..."
                                                   value="{{ $social['url'] ?? '' }}">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" name="socials[{{ $i }}][icon]"
                                                   class="form-control" placeholder="ex: fab fa-facebook"
                                                   value="{{ $social['icon'] ?? '' }}">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger w-100 remove-social">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row mb-2 social-link-row">
                                    <div class="col-md-5">
                                        <input type="url" name="socials[0][url]" class="form-control"
                                               placeholder="https://facebook.com/...">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="socials[0][icon]" class="form-control"
                                               placeholder="ex: fab fa-facebook">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger w-100 remove-social">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="mt-2">
                            <button type="button" class="btn btn-primary" id="add-social-link">
                                <i class="bi bi-plus-lg"></i> Tambah Sosial Media
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Judul Sertifikasi</label>
                        <input type="text" name="certification_title" 
                               class="form-control @error('certification_title') is-invalid @enderror"
                               value="{{ old('certification_title', $footer->certification_title) }}">
                        @error('certification_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Link Sertifikasi</label>
                        <div id="certification-links-container">
                            @if (old('certification_links', $footer->certification_links ?? []))
                                @foreach (old('certification_links', $footer->certification_links ?? []) as $i => $link)
                                    <div class="row mb-3 certification-link-row">
                                        <div class="col-md-5">
                                            <input type="url" name="certification_links[{{ $i }}][url]"
                                                   class="form-control" placeholder="https://example.com"
                                                   value="{{ $link['url'] ?? '' }}">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" name="certification_links[{{ $i }}][label]"
                                                   class="form-control" placeholder="Label" 
                                                   value="{{ $link['label'] ?? '' }}">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger w-100 remove-link">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row mb-3 certification-link-row">
                                    <div class="col-md-5">
                                        <input type="url" name="certification_links[0][url]" class="form-control"
                                               placeholder="https://example.com">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="certification_links[0][label]" class="form-control"
                                               placeholder="Label">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger w-100 remove-link">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="mt-2">
                            <button type="button" class="btn btn-primary" id="add-certification-link">
                                <i class="bi bi-plus-lg"></i> Tambah Link
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Judul Subscription</label>
                            <input type="text" name="subscription_title" 
                                   class="form-control @error('subscription_title') is-invalid @enderror"
                                   value="{{ old('subscription_title', $footer->subscription_title) }}">
                            @error('subscription_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tombol Subscription</label>
                            <input type="text" name="subscription_button" 
                                   class="form-control @error('subscription_button') is-invalid @enderror"
                                   value="{{ old('subscription_button', $footer->subscription_button) }}">
                            @error('subscription_button')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi Subscription</label>
                        <textarea name="subscription_text" class="form-control @error('subscription_text') is-invalid @enderror" 
                                  rows="3">{{ old('subscription_text', $footer->subscription_text) }}</textarea>
                        @error('subscription_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">URL Subscription</label>
                        <input type="url" name="subscription_url" 
                               class="form-control @error('subscription_url') is-invalid @enderror"
                               value="{{ old('subscription_url', $footer->subscription_url) }}"
                               placeholder="https://example.com">
                        @error('subscription_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-3">
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
    const previewContainer = document.getElementById('logoPreview');
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

let certIndex = {{ count(old('certification_links', $footer->certification_links ?? [])) }};
let socialIndex = {{ count(old('socials', $footer->socials ?? [])) }};

document.getElementById('add-certification-link').addEventListener('click', function() {
    const container = document.getElementById('certification-links-container');
    const row = document.createElement('div');
    row.classList.add('row', 'mb-3', 'certification-link-row');
    row.innerHTML = `
        <div class="col-md-5">
            <input type="url" name="certification_links[${certIndex}][url]" class="form-control" placeholder="https://example.com">
        </div>
        <div class="col-md-5">
            <input type="text" name="certification_links[${certIndex}][label]" class="form-control" placeholder="Label">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger w-100 remove-link"><i class="fa fa-trash"></i></button>
        </div>
    `;
    container.appendChild(row);
    certIndex++;
});

document.getElementById('add-social-link').addEventListener('click', function() {
    const container = document.getElementById('social-links-container');
    const row = document.createElement('div');
    row.classList.add('row', 'mb-2', 'social-link-row');
    row.innerHTML = `
        <div class="col-md-5">
            <input type="url" name="socials[${socialIndex}][url]" class="form-control" placeholder="https://facebook.com/...">
        </div>
        <div class="col-md-5">
            <input type="text" name="socials[${socialIndex}][icon]" class="form-control" placeholder="ex: bi bi-facebook">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger w-100 remove-social"><i class="fa fa-trash"></i></button>
        </div>
    `;
    container.appendChild(row);
    socialIndex++;
});

document.addEventListener('click', function(e) {
    if (e.target && e.target.classList.contains('remove-link')) {
        const row = e.target.closest('.certification-link-row');
        if (row) row.remove();
    }
    if (e.target && e.target.classList.contains('remove-social')) {
        const row = e.target.closest('.social-link-row');
        if (row) row.remove();
    }
});
</script>
@endpush