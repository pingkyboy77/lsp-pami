@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bx bx-bar-chart"></i> Statistik Section
                </h4>
            </div>
            <div class="card-body">
                @include('partials.alert')
                
                <form action="{{ route('admin.home.statistics.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title', $stat->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gambar Map</label>
                        @if ($stat->map_image)
                            <div class="mb-2">
                                <label class="form-label">Current Map Image</label>
                                <div class="border rounded p-3 text-center bg-light">
                                    <img src="{{ asset($stat->map_image) }}" alt="Current Map Image" 
                                         class="img-fluid" style="max-width: 300px; object-fit: contain;">
                                </div>
                                <div class="form-text">Leave image field empty to keep current image</div>
                            </div>
                        @endif
                        <input type="file" name="map_image" class="form-control @error('map_image') is-invalid @enderror"
                               accept="image/jpeg,image/png,image/jpg,image/svg,image/webp"
                               onchange="previewImage(event, 'map-preview')">
                        @error('map_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Supported: JPEG, PNG, JPG, SVG, WebP (Max: 2MB)</div>
                        
                        <!-- Map Preview -->
                        <div class="mt-2" id="mapPreview" style="display: none;">
                            <label class="form-label">Map Preview</label>
                            <div class="border rounded p-3 text-center bg-light">
                                <img id="map-preview" alt="Map Preview" 
                                     class="img-fluid" style="max-width: 300px; object-fit: contain;">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Item Statistik</label>
                        <div id="stat-items">
                            @php
                                $items = $stat->items ?? [];
                                $items = array_pad($items, 2, ['label' => '', 'count' => '']);
                            @endphp

                            @foreach ($items as $i => $item)
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <input name="items[{{ $i }}][label]" value="{{ $item['label'] ?? '' }}"
                                               class="form-control @error('items.'.$i.'.label') is-invalid @enderror" 
                                               placeholder="Label (contoh: Total Siswa)">
                                        @error('items.'.$i.'.label')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <input name="items[{{ $i }}][count]" value="{{ $item['count'] ?? '' }}"
                                               class="form-control @error('items.'.$i.'.count') is-invalid @enderror" 
                                               placeholder="Jumlah (contoh: 1,500)">
                                        @error('items.'.$i.'.count')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>
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
    const previewContainer = document.getElementById('mapPreview');
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