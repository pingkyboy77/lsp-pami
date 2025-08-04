@extends('layouts.admin')

@section('content')
@include('partials.alert')
    <div class="container mt-2 w-100">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bi bi-person"></i> Manage User
                </h4>
                <button class="btn btn-primary shadow-sm" id="addUser">
                    <i class="bi bi-plus-lg"></i>Add User
                </button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-responsive" id="usersTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @include('partials.user-modal')
@endsection

@push('scripts')
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function() {
            let table = $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.users.data') }}',
                columns: [{
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'role'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#addUser').on('click', function() {
                $('#userForm')[0].reset();
                $('#userId').val('');
                $('#passwordSection').show();
                $('#userModal').modal('show');
            });

            $('#usersTable').on('click', '.editUser', function() {
                let id = $(this).data('id');
                $.get(`/admin/users/${id}/edit`, function(data) {
                    $('#userId').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#role').val(data.role);
                    $('#passwordSection').hide();
                    $('#userModal').modal('show');
                });
            });

            $('#usersTable').on('click', '.deleteUser', function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This user will be permanently deleted.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/users/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                table.ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: res.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }
                        });
                    }
                });
            });

            $('#userForm').on('submit', function(e) {
                e.preventDefault();

                let id = $('#userId').val();
                let method = id ? 'PUT' : 'POST';
                let url = id ? `/admin/users/${id}` : "{{ route('admin.users.store') }}";

                $.ajax({
                    url: url,
                    method: method,
                    data: $(this).serialize(),
                    success: function(res) {
                        $('#userModal').modal('hide');
                        table.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMsg = '';
                        for (let field in errors) {
                            errorMsg += `• ${errors[field][0]}<br>`;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Failed to save!',
                            html: errorMsg
                        });
                    }
                });
            });
        });
    </script>
@endpush
