@extends('layouts.admin')

@section('content')
    <div class="container-fluid mt-4">
        @include('partials.alert')

        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-certificate me-2"></i>
                        Sceme Certification Management
                    </h4>
                </div>

                <!-- Parent Certifications Table -->
                <div class="card border-0 shadow-lg rounded-4 mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-folder"></i>Parent Sceme
                        </h4>
                        <button class="btn btn-primary shadow-sm">
                            <a href="{{ route('admin.sertifikasi.create', ['parent_id' => 'parent']) }}"
                                class="text-light text-decoration-none"><i class="bi bi-plus-lg"></i> Add Parent Sceme</a>
                        </button>
                    </div>
                    <div class="card-body p-2">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0" id="parentTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-4 py-3 fw-semibold text-muted">#</th>
                                        <th class="px-4 py-3 fw-semibold text-muted">Title</th>
                                        <th class="px-4 py-3 fw-semibold text-muted text-center">Sub Count</th>
                                        <th class="px-4 py-3 fw-semibold text-muted text-center">Status</th>
                                        <th class="px-4 py-3 fw-semibold text-muted text-center">Image</th>
                                        <th class="px-4 py-3 fw-semibold text-muted">Created</th>
                                        <th class="px-4 py-3 fw-semibold text-muted text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be loaded via DataTables -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Child Certifications Table -->
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-certificate"></i>Sub Sceme
                        </h4>
                        <button class="btn btn-primary shadow-sm">
                            <a href="{{ route('admin.sertifikasi.create') }}"
                                class="text-light text-decoration-none"><i class="bi bi-plus-lg"></i> Add Sub-Sceme</a>
                        </button>
                    </div>
                    <div class="card-body p-2">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped  mb-0" id="childTable">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 fw-semibold text-muted">#</th>
                                        <th class="px-4 py-3 fw-semibold text-muted">Title</th>
                                        <th class="px-4 py-3 fw-semibold text-muted">Parent</th>
                                        <th class="px-4 py-3 fw-semibold text-muted text-center">Status</th>
                                        <th class="px-4 py-3 fw-semibold text-muted">Created</th>
                                        <th class="px-4 py-3 fw-semibold text-muted text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be loaded via DataTables -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-danger text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Delete Confirmation
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-3">
                        <i class="fas fa-trash-alt text-danger" style="font-size: 3rem;"></i>
                    </div>
                    <p class="text-center mb-3">Are you sure you want to delete this certification?</p>
                    <div class="alert alert-warning border-0 rounded-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-certificate text-warning me-2"></i>
                            <strong id="itemTitle" class="text-dark"></strong>
                        </div>
                    </div>
                    <p class="text-muted small text-center mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        This action cannot be undone.
                    </p>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-pill px-4">
                            <i class="fas fa-trash me-2"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')

    <script>
        $(document).ready(function() {
            console.log('Document ready');
            console.log('jQuery version:', $.fn.jquery);
            console.log('DataTables available:', typeof $.fn.DataTable !== 'undefined');

            // Wait a bit to ensure all scripts are loaded
            setTimeout(function() {
                initializeDataTables();
            }, 100);

            function initializeDataTables() {
                if (typeof $.fn.DataTable === 'undefined') {
                    console.error('DataTables is not loaded! Please check your script includes.');
                    showError('DataTables library is not loaded properly.');
                    return;
                }

                try {
                    // Initialize Parent Certifications DataTable
                    let parentTable = $('#parentTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{{ route('admin.sertifikasi.index') }}',
                            data: {
                                type: 'parent'
                            }, // Add parameter to filter parent only
                            error: function(xhr, error, thrown) {
                                console.error('Parent DataTable Ajax error:', error);
                                showError(
                                    'Failed to load parent certifications data. Please refresh the page.'
                                    );
                            }
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false,
                                className: 'text-center fw-bold text-muted'
                            },
                            {
                                data: 'title',
                                name: 'title',
                                className: 'fw-semibold'
                            },
                            {
                                data: 'children_count',
                                name: 'children_count',
                                orderable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'is_active',
                                name: 'is_active',
                                orderable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'image',
                                name: 'image',
                                orderable: false,
                                searchable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'created_at',
                                name: 'created_at',
                                className: 'text-muted'
                            },
                            {
                                data: 'parent_action', // Different action column for parent
                                name: 'parent_action',
                                orderable: false,
                                searchable: false,
                                className: 'text-center parent-actions'
                            }
                        ],
                        order: [
                            [5, 'desc']
                        ],
                        pageLength: 10,
                        responsive: true,
                        drawCallback: function() {
                            $('#parentTable tbody tr').addClass('fade-in');
                        }
                    });

                    // Initialize Child Certifications DataTable
                    let childTable = $('#childTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{{ route('admin.sertifikasi.index') }}',
                            data: {
                                type: 'child'
                            }, // Add parameter to filter children only
                            error: function(xhr, error, thrown) {
                                console.error('Child DataTable Ajax error:', error);
                                showError(
                                    'Failed to load sub-certifications data. Please refresh the page.'
                                    );
                            }
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false,
                                className: 'text-center fw-bold text-muted'
                            },
                            {
                                data: 'title',
                                name: 'title',
                                className: 'fw-semibold'
                            },
                            {
                                data: 'parent',
                                name: 'parent',
                                orderable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'is_active',
                                name: 'is_active',
                                orderable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'created_at',
                                name: 'created_at',
                                className: 'text-muted'
                            },
                            {
                                data: 'child_action', // Different action column for child
                                name: 'child_action',
                                orderable: false,
                                searchable: false,
                                className: 'text-center child-actions'
                            }
                        ],
                        order: [
                            [5, 'desc']
                        ],
                        pageLength: 10,
                        responsive: true,
                        drawCallback: function() {
                            $('#childTable tbody tr').addClass('fade-in');
                        }
                    });

                    console.log('DataTables initialized successfully');

                    // Delete functionality (works for both tables)
                    $(document).on('click', '.delete-btn', function() {
                        let id = $(this).data('id');
                        let title = $(this).data('title');

                        $('#itemTitle').html('<i class="fas fa-quote-left me-1"></i>' + title +
                            '<i class="fas fa-quote-right ms-1"></i>');
                        $('#deleteForm').attr('action', '{{ route('admin.sertifikasi.destroy', '') }}/' +
                            id);
                        $('#deleteModal').modal('show');
                    });

                    // Status toggle (works for both tables)
                    $(document).on('click', '.toggle-status', function() {
                        let id = $(this).data('id');
                        let button = $(this);

                        button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

                        $.ajax({
                            url: '{{ route('admin.sertifikasi.toggle-status', '') }}/' + id,
                            type: 'POST',
                            data: {
                                '_token': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    showToast('success', response.message);
                                    // Reload both tables
                                    parentTable.ajax.reload(null, false);
                                    childTable.ajax.reload(null, false);
                                }
                            },
                            error: function() {
                                showToast('error', 'Failed to update status');
                            },
                            complete: function() {
                                button.prop('disabled', false);
                            }
                        });
                    });

                } catch (error) {
                    console.error('Error initializing DataTables:', error);
                    showError('Failed to initialize data tables: ' + error.message);
                }
            }

            // Toast notification function
            function showToast(type, message) {
                const toastClass = type === 'success' ? 'bg-success' : 'bg-danger';
                const icon = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';

                const toast = $(`
            <div class="toast align-items-center text-white ${toastClass} border-0 position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999;" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="${icon} me-2"></i>${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" 
                            data-bs-dismiss="toast"></button>
                </div>
            </div>
        `);

                $('body').append(toast);
                toast.toast({
                    delay: 3000
                }).toast('show').on('hidden.bs.toast', function() {
                    $(this).remove();
                });
            }

            // Error display function
            function showError(message) {
                const errorDiv = $(`
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Error:</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);

                $('.container-fluid').prepend(errorDiv);
            }
        });
    </script>
@endpush
