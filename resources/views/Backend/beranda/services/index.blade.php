{{-- resources/views/admin/services/index.blade.php --}}
@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="card rounded-4 shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bx bx-certification"></i> Service Management
                </h4>
                    <button class="btn btn-primary shadow-sm">
                    <a href="{{ route('admin.home.services.create') }}" class="text-light text-decoration-none"><i class="bi bi-plus-lg"></i> Add Service</a>
                    </button>
            </div>
            <div class="card-body">

                @include('partials.alert')
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="servicesTable">
                        <thead>
                            <tr>
                                <th>Icon</th>
                                <th>Title</th>
                                <th>URL</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('partials.modal-delete')
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#servicesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.home.services.index') }}',
                columns: [{
                        data: 'icon',
                        name: 'icon',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'url',
                        name: 'url'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endpush
