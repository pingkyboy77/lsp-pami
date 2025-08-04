@extends('layouts.admin')
@section('content')
    <div class="container mt-4">
        <div class="card rounded-4 shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bx bx-certification"></i> Association Management
                </h4>
                <button class="btn btn-primary shadow-sm">
                    <a href="{{ route('admin.home.associations.create') }}" class="text-light text-decoration-none"><i
                            class="bi bi-plus-lg"></i> Add Associations</a>
                </button>
            </div>
            <div class="card-body">
                @include('partials.alert')
                <div class="table-responsive">
                    <table class="table table-bordered" id="associationTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Image</th>
                                <th width="150">Actions</th>
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
            $('#associationTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.home.associations.index') }}',
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
