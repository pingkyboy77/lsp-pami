@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card rounded-4 shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit Halaman: {{ $page->title }}</h4>
        </div>
        <div class="card-body">
            @include('partials.alert')

            <form action="{{ route('admin.paralel.update', $page->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Judul Halaman</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $page->title) }}">
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Banner (Opsional)</label><br>

                    {{-- Tampilkan banner lama jika ada --}}
                    @if ($page->banner)
                        <img src="{{ asset('storage/' . $page->banner) }}" class="img-fluid rounded mb-2" style="max-height: 150px;">
                    @endif

                    {{-- Input upload file dengan preview --}}
                    <input type="file" name="banner" id="bannerInput" class="form-control" accept="image/*" onchange="previewBanner(event)">
                    <small class="text-muted">Format: JPG, PNG, Max 2MB</small>

                    {{-- Preview container --}}
                    <div class="mt-2" id="bannerPreviewContainer" style="{{ $page->banner ? '' : 'display:none;' }}">
                        <label class="form-label text-muted">Preview Banner</label>
                        <div class="border rounded p-3 text-center bg-light">
                            <img id="bannerPreview" src="{{ $page->banner ? asset('storage/' . $page->banner) : '' }}" alt="Preview Banner" class="img-fluid rounded" style="max-height: 150px; object-fit: cover;">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Konten Halaman</label>
                    <textarea name="content" id="editor" class="form-control" rows="8">{{ old('content', $page->content) }}</textarea>
                    @error('content')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ $page->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Aktifkan halaman ini</label>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script preview image --}}
<script>
function previewBanner(event) {
    const input = event.target;
    const previewContainer = document.getElementById('bannerPreviewContainer');
    const previewImage = document.getElementById('bannerPreview');

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
