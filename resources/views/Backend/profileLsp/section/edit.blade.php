@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil-square"></i> Edit Section: {{ $section->title }}
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.lsp.sections.update', $section->key) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="key" class="form-label">Key</label>
                            <input type="text" 
                                   name="key" 
                                   id="key" 
                                   class="form-control" 
                                   value="{{ $section->key }}" 
                                   disabled>
                            <div class="form-text">Key tidak dapat diubah setelah dibuat</div>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title', $section->title) }}" 
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Konten</label>
                            <textarea name="content" 
                                      id="editor" 
                                      class="form-control @error('content') is-invalid @enderror" 
                                      rows="10">{{ old('content', $section->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="order" class="form-label">Urutan</label>
                            <input type="number" 
                                   name="order" 
                                   id="order" 
                                   class="form-control @error('order') is-invalid @enderror" 
                                   value="{{ old('order', $section->order) }}">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.lsp.sections.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Update Section
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-eye"></i> Preview Content
                    </h5>
                </div>
                <div class="card-body">
                    {{-- <h6 class="fw-semibold">{{ $section->title }}</h6> --}}
                    <div class="mt-2">
                        {!! $section->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
