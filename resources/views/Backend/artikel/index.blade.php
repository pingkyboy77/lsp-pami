@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        {{-- Artikel Management Card --}}
        <div class="card rounded-4 shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bi bi-building"></i> Artikel Management
                </h4>
                <a href="{{ route('admin.artikel.create') }}" class="btn btn-primary shadow-sm">
                    <i class="bi bi-plus-lg"></i> Add Artikel
                </a>
            </div>
            <div class="card-body table-responsive">
                @include('partials.alert')
                
                <table class="table table-bordered table-striped " id="artikelTable">
                    <thead>
                        <tr>
                            <th width="80">Image</th>
                            <th width="100">Title</th>
                            <th width="80">Status</th>
                            <th width="120">Action</th>
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
            // Initialize DataTable
            $('#artikelTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.artikel.data') }}',
                columns: [
                    {
                        data: 'image_display',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'status',
                        name: 'is_active',
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [2, 'asc']
                ], // Order by 'order' column
                pageLength: 10,
                responsive: true
            });
        });

        function deleteItem(id) {
            $('#deleteModal').modal('show');
            $('#deleteForm').attr('action', '{{ route("admin.artikel.destroy", ":id") }}'.replace(':id', id));
        }
    </script>
@endpush