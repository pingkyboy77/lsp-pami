@extends('layouts.admin')

@section('title', 'Edit FAQ')

@section('content')
<style>
.modern-title {
    background: linear-gradient(135deg, #204053FF 0%, #1e3a8a 100%);
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-size: clamp(1.5rem, 4vw, 2.5rem);
    font-weight: 800;
    letter-spacing: -0.02em;
    line-height: 1.2;
    margin-bottom: 1.5rem;
    position: relative;
    font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
}

.modern-title::before {
    content: '';
    position: absolute;
    top: -10px;
    left: 0;
    width: 60px;
    height: 3px;
    background: linear-gradient(135deg, #204053FF 0%, #1e3a8a 100%);
    border-radius: 2px;
    opacity: 0.8;
}

.modern-hr {
    border: none;
    height: 2px;
    background: linear-gradient(135deg, #204053FF 0%, #1e3a8a 100%);
    margin: 1.5rem 0;
    max-width: 100px;
    border-radius: 1px;
    box-shadow: 0 2px 8px rgba(32, 64, 83, 0.3);
}
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('faq.index') }}" class="text-decoration-none">FAQ</a></li>
                    <li class="breadcrumb-item active">Edit FAQ</li>
                </ol>
            </nav>

            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h2 class="modern-title">Edit FAQ</h2>
                    <hr class="modern-hr">
                    <p class="text-muted mb-0">Perbarui pertanyaan dan jawaban FAQ</p>
                </div>
                
                <div class="card-body">
                    <form id="editFaqForm" action="{{ route('faq.update', $faq->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="mb-4">
                                    <label for="question" class="form-label fw-semibold">
                                        Pertanyaan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('question') is-invalid @enderror" 
                                           id="question" 
                                           name="question" 
                                           value="{{ old('question', $faq->question) }}" 
                                           placeholder="Masukkan pertanyaan..."
                                           required>
                                    @error('question')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="answer" class="form-label fw-semibold">
                                        Jawaban <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('answer') is-invalid @enderror" 
                                              id="answer" 
                                              name="answer" 
                                              rows="8" 
                                              placeholder="Masukkan jawaban lengkap..."
                                              required>{{ old('answer', $faq->answer) }}</textarea>
                                    @error('answer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Anda dapat menggunakan HTML untuk formatting jawaban.</div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card bg-light">
                                    <div class="card-header bg-transparent border-bottom-0">
                                        <h6 class="card-title mb-0 fw-semibold">Pengaturan</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="sort_order" class="form-label fw-semibold">Urutan Tampil</label>
                                            <input type="number" 
                                                   class="form-control @error('sort_order') is-invalid @enderror" 
                                                   id="sort_order" 
                                                   name="sort_order" 
                                                   value="{{ old('sort_order', $faq->sort_order) }}" 
                                                   min="0">
                                            @error('sort_order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Semakin kecil angka, semakin atas posisinya.</div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       id="is_active" 
                                                       name="is_active" 
                                                       value="1"
                                                       {{ old('is_active', $faq->is_active) ? 'checked' : '' }}>
                                                <label class="form-check-label fw-semibold" for="is_active">
                                                    Aktif
                                                </label>
                                            </div>
                                            <div class="form-text">FAQ akan ditampilkan di halaman publik jika diaktifkan.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Informasi</label>
                                            <div class="small text-muted">
                                                <div><strong>Dibuat:</strong> {{ $faq->created_at->format('d/m/Y H:i') }}</div>
                                                <div><strong>Diupdate:</strong> {{ $faq->updated_at->format('d/m/Y H:i') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('faq.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <div>
                                <button type="reset" class="btn btn-outline-warning me-2">
                                    <i class="fas fa-undo me-1"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="fas fa-save me-1"></i> Update FAQ
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#editFaqForm').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const submitBtn = $('#submitBtn');
        const formData = new FormData(this);
        
        // Disable submit button
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Mengupdate...');
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "{{ route('faq.index') }}";
                    });
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Clear previous errors
                    $('.form-control').removeClass('is-invalid');
                    $('.invalid-feedback').remove();
                    
                    // Show validation errors
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(key => {
                        const input = $(`[name="${key}"]`);
                        input.addClass('is-invalid');
                        input.after(`<div class="invalid-feedback">${errors[key][0]}</div>`);
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'Terjadi kesalahan saat mengupdate data'
                    });
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Update FAQ');
            }
        });
    });
});
</script>
@endpush