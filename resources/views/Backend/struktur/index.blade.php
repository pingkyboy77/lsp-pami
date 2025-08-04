@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card rounded-4 shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Organizational Structure</h4>
        </div>
        <div class="card-body">
            @include('partials.alert')

            {{-- Update Title Form --}}
            <form action="{{ route('admin.struktur.updateTitle') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Page Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $title) }}">
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="d-flex justify-content-end mb-4">
                    <button type="submit" class="btn btn-primary">Save Title</button>
                </div>
            </form>

            <hr>

            {{-- Add Image Form --}}
            <form action="{{ route('admin.struktur.appendImage') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Upload Organizational Structure Image</label>
                    <input type="file" name="image" id="imageInput" class="form-control" accept="image/*" onchange="previewImage(event)">
                    <small class="text-muted">Format: JPG, PNG, Max 2MB</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description / Alt Text</label>
                    <input type="text" name="alt" class="form-control" placeholder="e.g., Surabaya Branch Structure">
                </div>

                {{-- Image Preview --}}
                <div class="mb-4" id="previewContainer" style="display: none;">
                    <label class="form-label text-muted">Image Preview</label>
                    <div class="border rounded p-3 text-center bg-light">
                        <img id="previewImage" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px; object-fit: contain;">
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-success">Add Image</button>
                </div>
            </form>

            <hr>

            {{-- Image List --}}
            <div class="row mt-4 g-4">
                @forelse ($struktur_images as $index => $img)
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-body text-center">
                                <img src="{{ asset($img['path']) }}" class="img-fluid rounded mb-2" style="max-height: 200px; object-fit: contain;">
                                <p class="mb-1">{{ $img['alt'] ?? 'No Description' }}</p>
                                <form action="{{ route('admin.struktur.deleteImage', $index) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this image?')">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning text-center">No organizational structure images available.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- JS Image Preview --}}
<script>
function previewImage(event) {
    const input = event.target;
    const previewImage = document.getElementById('previewImage');
    const previewContainer = document.getElementById('previewContainer');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewContainer.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        previewImage.src = '';
        previewContainer.style.display = 'none';
    }
}
</script>
@endsection
