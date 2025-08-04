@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bx bx-id-card"></i> Profil Section
            </h4>
        </div>
        <div class="card-body">
            @include('partials.alert')
            
            <form action="{{ route('admin.home.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Judul <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                           value="{{ old('title', $profile->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Paragraf 1 <span class="text-danger">*</span></label>
                    <textarea name="paragraph_1" class="form-control @error('paragraph_1') is-invalid @enderror" 
                              rows="3" required>{{ old('paragraph_1', $profile->paragraph_1) }}</textarea>
                    @error('paragraph_1')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Paragraf 2</label>
                    <textarea name="paragraph_2" class="form-control @error('paragraph_2') is-invalid @enderror" 
                              rows="3">{{ old('paragraph_2', $profile->paragraph_2) }}</textarea>
                    @error('paragraph_2')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teks Tombol</label>
                        <input type="text" name="button_text" class="form-control @error('button_text') is-invalid @enderror" 
                               value="{{ old('button_text', $profile->button_text) }}">
                        @error('button_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Link Tombol</label>
                        <input type="url" name="button_url" class="form-control @error('button_url') is-invalid @enderror" 
                               value="{{ old('button_url', $profile->button_url) }}" placeholder="https://example.com">
                        @error('button_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Teks Kartu Profil</label>
                    <textarea name="card_text" class="form-control @error('card_text') is-invalid @enderror" 
                              rows="4">{{ old('card_text', $profile->card_text) }}</textarea>
                    @error('card_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">URL Video</label>
                    <input type="url" name="video_url" class="form-control @error('video_url') is-invalid @enderror" 
                           value="{{ old('video_url', $profile->video_url) }}" placeholder="https://youtube.com/watch?v=...">
                    @error('video_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">URL video YouTube atau platform lainnya</div>
                </div>

                <div class="d-flex justify-content-end gap-2">
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