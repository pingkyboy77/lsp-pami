@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="card rounded-4 shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bx bx-certification"></i> Certification Scheme Management
                </h4>
                    <button class="btn btn-primary shadow-sm">
                    <a href="{{ route('admin.home.certifications.create') }}" class="text-light text-decoration-none"><i class="bi bi-plus-lg"></i> Add Scheme</a>
                    </button>
            </div>
            <div class="card-body">
                @include('partials.alert')

                <table class="table table-bordered table-striped" id="schemeTable">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Icon</th>
                            <th>Url</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @include('partials.modal-delete')
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#schemeTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.home.certifications.index') }}',
                columns: [{
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'icon',
                        name: 'icon',
                        orderable: false,
                        searchable: false
                    },  
                    {
                        data: 'url',
                        name: 'url',
                        orderable: false,
                        searchable: false
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

@push('styles')
    <style>
        .img-icon {
            max-width: 60px;
            max-height: 60px;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }
    </style>
@endpush
