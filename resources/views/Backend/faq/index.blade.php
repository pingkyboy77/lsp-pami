{{-- resources/views/admin/faq/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Kelola FAQ')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="bi bi-x-diamond"></i> Manage FAQ
                        </h4>

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#faqModal">
                                <i class="fas fa-plus"></i> Tambah FAQ
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="faqTable">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="25%">Pertanyaan</th>
                                        <th width="35%">Jawaban</th>
                                        <th width="10%">Status</th>
                                        <th width="10%">Urutan</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal FAQ -->
    <div class="modal fade" id="faqModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="faqModalTitle">Tambah FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="faqForm">
                    <div class="modal-body">
                        <input type="hidden" id="faqId" name="id">

                        <div class="mb-3">
                            <label for="question" class="form-label">Pertanyaan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="question" name="question" required>
                            <div class="invalid-feedback" id="questionError"></div>
                        </div>

                        <div class="mb-3">
                            <label for="answer" class="form-label">Jawaban <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="editor" name="answer" rows="5"></textarea>
                            <div class="invalid-feedback" id="answerError"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Urutan</label>
                                    <input type="number" class="form-control" id="sort_order" name="sort_order"
                                        value="0" min="0">
                                    <div class="invalid-feedback" id="sortOrderError"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Status</label>
                                    <select class="form-select" id="is_active" name="is_active">
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                    <div class="invalid-feedback" id="is_activeError"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const table = $('#faqTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.faq.data') }}",
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'question',
                        name: 'question'
                    },
                    {
                        data: 'answer_preview',
                        name: 'answer'
                    },
                    {
                        data: 'status',
                        name: 'is_active',
                        orderable: false
                    },
                    {
                        data: 'sort_order',
                        name: 'sort_order'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [4, 'asc']
                ],
            });

            function resetForm() {
                $('#faqForm')[0].reset();
                $('#faqId').val('');
                $('#faqModalTitle').text('Tambah FAQ');
                $('#submitBtn').text('Simpan');
                $('.form-control, .form-select').removeClass('is-invalid');
                $('.invalid-feedback').text('');
            }

            $('#faqModal').on('show.bs.modal', function() {
                if (!$('#faqId').val()) {
                    resetForm();
                    $.get("{{ route('admin.faq.data') }}", function(response) {
                        let maxSortOrder = 0;
                        if (response.data && response.data.length > 0) {
                            maxSortOrder = Math.max(...response.data.map(item => parseInt(item
                                .sort_order) || 0));
                        }
                        $('#sort_order').val(maxSortOrder + 1);
                    }).fail(function() {
                        $('#sort_order').val(1);
                    });
                }
            });

            $('#faqForm').on('submit', function(e) {
                e.preventDefault();

                if (typeof tinymce !== 'undefined' && tinymce.get('editor')) {
                    tinymce.get('editor').save();
                }

                const answerContent = $('[name="answer"]').val().trim();
                if (!answerContent) {
                    $('[name="answer"]').addClass('is-invalid');
                    $('#answerError').text('Jawaban wajib diisi.');
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validasi Error!',
                        text: 'Jawaban wajib diisi.'
                    });
                    return false;
                } else {
                    $('[name="answer"]').removeClass('is-invalid');
                    $('#answerError').text('');
                }

                const faqId = $('#faqId').val();
                const url = faqId ? `/admin/faq/${faqId}` : "{{ route('admin.faq.store') }}";
                const method = faqId ? 'PUT' : 'POST';

                const formData = {
                    question: $('#question').val(),
                    answer: answerContent,
                    sort_order: $('#sort_order').val(),
                    is_active: $('#is_active').val(),
                    _token: "{{ csrf_token() }}"
                };

                if (method === 'PUT') {
                    formData._method = 'PUT';
                }

                $('#submitBtn').prop('disabled', true).text('Menyimpan...');

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#faqModal').modal('hide');
                            table.ajax.reload();

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            $('.form-control, .form-select').removeClass('is-invalid');
                            $('.invalid-feedback').text('');
                            Object.keys(errors).forEach(key => {
                                $(`#${key}`).addClass('is-invalid');
                                $(`#${key}Error`).text(errors[key][0]);
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: xhr.responseJSON?.message || 'Terjadi kesalahan'
                            });
                        }
                    },
                    complete: function() {
                        $('#submitBtn').prop('disabled', false).text('Simpan');
                    }
                });
            });
        });

        function editFaq(id) {
            $.get(`/admin/faq/${id}`, function(data) {
                $('#faqId').val(data.id);
                $('#question').val(data.question);

                if (typeof tinymce !== 'undefined' && tinymce.get('editor')) {
                    tinymce.get('editor').setContent(data.answer);
                } else {
                    $('#answer').val(data.answer);
                }

                $('#sort_order').val(data.sort_order);
                $('#is_active').val(data.is_active == 1 ? '1' : '0');

                $('#faqModalTitle').text('Edit FAQ');
                $('#submitBtn').text('Update');
                $('#faqModal').modal('show');
            }).fail(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'FAQ tidak ditemukan'
                });
            });
        }

        function deleteFaq(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This Data will be permanently deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/faq/${id}`,
                        method: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#faqTable').DataTable().ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Terhapus!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: xhr.responseJSON?.message || 'Gagal menghapus FAQ'
                            });
                        }
                    });
                }
            });
        }
    </script>
@endpush
