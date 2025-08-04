
@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="card rounded-4 shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bi bi-file-text"></i> Profile Section Management
                </h4>
                <button class="btn btn-primary shadow-sm">
                    <a href="{{ route('admin.lsp.sections.create') }}" class="text-light text-decoration-none">
                        <i class="bi bi-plus-lg"></i> Add Section
                    </a>
                </button>
            </div>
            <div class="card-body">

                @include('partials.alert')

                <table class="table table-bordered table-striped" id="sectionsTable">
                    <thead>
                        <tr>
                            <th>Key</th>
                            <th>Title</th>
                            <th>Content Preview</th>
                            <th>Order</th>
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
        $(function() {
            $('#sectionsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.lsp.sections.data') }}',
                columns: [
                    {
                        data: 'key',
                        name: 'key',
                        orderable: false,
                    },
                    {
                        data: 'title',
                        name: 'title',
                        orderable: false,
                    },
                    {
                        data: 'content_preview',
                        name: 'content',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'order',
                        name: 'order',
                        orderable: false,
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