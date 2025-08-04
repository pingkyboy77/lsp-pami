@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="card rounded-4 shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bi bi-person-arms-up"></i> Manage Sambutan
                </h4>
            </div>
            <div class="card-body">
                @include('partials.alert')

                <form action="{{ route('admin.sambutan.update', $sambutan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Page Title --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Page Title</label>
                        <input type="text" name="page_title"
                            class="form-control @error('page_title') is-invalid @enderror"
                            value="{{ old('page_title', $sambutan->page_title) }}" placeholder="e.g., Sambutan">
                        @error('page_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Judul utama halaman sambutan. Kosongkan jika tidak ingin menampilkan banner
                            judul.</div>
                    </div>

                    <hr class="my-4">

                    {{-- Dewan Pengarah --}}
                    <div class="mb-4">
                        <h5 class="text-primary mb-3"><i class="bi bi-person-badge"></i> Sambutan Dewan Pengarah</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="pengarah_name"
                                    class="form-control @error('pengarah_name') is-invalid @enderror"
                                    value="{{ old('pengarah_name', $sambutan->pengarah_name) }}"
                                    placeholder="e.g., Budi Ruseno">
                                @error('pengarah_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jabatan</label>
                                <input type="text" name="pengarah_title"
                                    class="form-control @error('pengarah_title') is-invalid @enderror"
                                    value="{{ old('pengarah_title', $sambutan->pengarah_title) }}"
                                    placeholder="e.g., Ketua Dewan Pengarah">
                                @error('pengarah_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Image Upload --}}
                        <div class="mb-3">
                            <label class="form-label">Foto</label>
                            @if ($sambutan->pengarah_image)
                                <div class="mb-2">
                                    <label class="form-label text-muted">Current Photo</label>
                                    <div class="border rounded p-3 text-center bg-light">
                                        <img src="{{ asset($sambutan->pengarah_image) }}" alt="Current Photo"
                                            class="img-fluid rounded" style="max-height: 150px; object-fit: cover;">
                                    </div>
                                    <div class="form-text">Kosongkan field foto untuk mempertahankan foto saat ini</div>
                                </div>
                            @endif
                            <input type="file" name="pengarah_image"
                                class="form-control @error('pengarah_image') is-invalid @enderror"
                                accept="image/jpeg,image/png,image/jpg,image/svg,image/webp"
                                onchange="previewImage(event, 'pengarah-preview', 'pengarahPreview')">
                            @error('pengarah_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Supported: JPEG, PNG, JPG, SVG, WebP (Max: 2MB)</div>

                            <!-- Image Preview -->
                            <div class="mt-2" id="pengarahPreview" style="display: none;">
                                <label class="form-label text-muted">Preview</label>
                                <div class="border rounded p-3 text-center bg-light">
                                    <img id="pengarah-preview" alt="Preview" class="img-fluid rounded"
                                        style="max-height: 150px; object-fit: cover;">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Konten Sambutan</label>
                                <textarea name="pengarah_content" id="editor" class="form-control @error('pengarah_content') is-invalid @enderror"
                                    rows="6">{{ old('pengarah_content', $sambutan->pengarah_content) }}</textarea>
                                @error('pengarah_content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Anda dapat menggunakan HTML tags untuk formatting. Kosongkan untuk
                                    menyembunyikan section ini.</div>
                            </div>

                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- Dewan Pelaksana --}}
                    <div class="mb-4">
                        <h5 class="text-primary mb-3"><i class="bi bi-person-lines-fill"></i> Sambutan Dewan Pelaksana</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="pelaksana_name"
                                    class="form-control @error('pelaksana_name') is-invalid @enderror"
                                    value="{{ old('pelaksana_name', $sambutan->pelaksana_name) }}"
                                    placeholder="e.g., Siti Aisyah">
                                @error('pelaksana_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jabatan</label>
                                <input type="text" name="pelaksana_title"
                                    class="form-control @error('pelaksana_title') is-invalid @enderror"
                                    value="{{ old('pelaksana_title', $sambutan->pelaksana_title) }}"
                                    placeholder="e.g., Direktur">
                                @error('pelaksana_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Image Upload --}}
                        <div class="mb-3">
                            <label class="form-label">Foto</label>
                            @if ($sambutan->pelaksana_image)
                                <div class="mb-2">
                                    <label class="form-label text-muted">Current Photo</label>
                                    <div class="border rounded p-3 text-center bg-light">
                                        <img src="{{ asset($sambutan->pelaksana_image) }}" alt="Current Photo"
                                            class="img-fluid rounded" style="max-height: 150px; object-fit: cover;">
                                    </div>
                                    <div class="form-text">Kosongkan field foto untuk mempertahankan foto saat ini</div>
                                </div>
                            @endif
                            <input type="file" name="pelaksana_image"
                                class="form-control @error('pelaksana_image') is-invalid @enderror"
                                accept="image/jpeg,image/png,image/jpg,image/svg,image/webp"
                                onchange="previewImage(event, 'pelaksana-preview', 'pelaksanaPreview')">
                            @error('pelaksana_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Supported: JPEG, PNG, JPG, SVG, WebP (Max: 2MB)</div>

                            <!-- Image Preview -->
                            <div class="mt-2" id="pelaksanaPreview" style="display: none;">
                                <label class="form-label text-muted">Preview</label>
                                <div class="border rounded p-3 text-center bg-light">
                                    <img id="pelaksana-preview" alt="Preview" class="img-fluid rounded"
                                        style="max-height: 150px; object-fit: cover;">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Konten Sambutan</label>
                                <textarea name="pelaksana_content" id="editor"
                                    class="form-control @error('pelaksana_content') is-invalid @enderror" rows="6">{{ old('pelaksana_content', $sambutan->pelaksana_content) }}</textarea>
                                @error('pelaksana_content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Anda dapat menggunakan HTML tags untuk formatting. Kosongkan untuk
                                    menyembunyikan section ini.</div>
                            </div>

                        </div>
                    </div>

                    {{-- Active Status --}}
                    {{-- <div class="mb-4">
                        <label class="form-label">Aktif</label>
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $sambutan->is_active) ? 'checked' : '' }} class="form-check-input">
                    </div> --}}

                    {{-- Submit --}}
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

    <script>
        // Function for previewing images
        function previewImage(event, imageId, previewId) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById(imageId);
                output.src = reader.result;
                document.getElementById(previewId).style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
