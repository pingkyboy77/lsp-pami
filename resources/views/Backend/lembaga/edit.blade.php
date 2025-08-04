@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="card rounded-4 shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bi bi-pencil"></i> Edit Lembaga Pelatihan
                </h4>
                <a href="{{ route('admin.lembaga.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>
            <div class="card-body">
                @include('partials.alert')

                <form action="{{ route('admin.lembaga.update', $lembaga->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $lembaga->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Current Image</label>
                        @if($lembaga->image)
                            <div class="mb-2">
                                <img src="{{ asset($lembaga->image) }}" alt="Current Image" 
                                    style="max-width: 200px; height: auto; border-radius: 5px;">
                            </div>
                        @else
                            <p class="text-muted">No image uploaded</p>
                        @endif
                        
                        <label class="form-label">Upload New Image</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                            accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Leave empty to keep current image. Maximum file size: 2MB.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea name="content" id="editor" class="form-control @error('content') is-invalid @enderror"
                            rows="10" required>{{ old('content', $lembaga->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Order <span class="text-danger">*</span></label>
                        <input type="number" name="order" class="form-control @error('order') is-invalid @enderror"
                            value="{{ old('order', $lembaga->order) }}" min="0" required>
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Lower numbers appear first</div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
                                value="1" {{ old('is_active', $lembaga->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-lg"></i> Update Lembaga
                        </button>
                        <a href="{{ route('admin.lembaga.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection