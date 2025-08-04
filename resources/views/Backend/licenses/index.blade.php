@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        {{-- License Settings Card --}}
        <div class="card rounded-4 shadow-sm border-0 mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bi bi-gear"></i> License Page Settings
                </h4>
            </div>
            <div class="card-body">
                @include('partials.alert')

                <form action="{{ route('admin.licenses.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Page Title <span class="text-danger">*</span></label>
                        <input type="text" name="license_title"
                            class="form-control @error('license_title') is-invalid @enderror"
                            value="{{ old('license_title', $settings['license_title']) }}" required>
                        @error('license_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">This will be displayed as the main title on the license page</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Page Description <span class="text-danger">*</span></label>
                        <textarea name="license_description" class="form-control @error('license_description') is-invalid @enderror"
                            rows="4" required>{{ old('license_description', $settings['license_description']) }}</textarea>
                        @error('license_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">This description will appear below the title</div>
                    </div>

                    <div class="d-flex justify-content-end gap-3">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-lg"></i> Save Settings
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- License Management Card --}}
        <div class="card rounded-4 shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bi bi-card-checklist"></i> License Management
                </h4>
                <a href="{{ route('admin.licenses.create') }}" class="btn btn-primary shadow-sm">
                    <i class="bi bi-plus-lg"></i> Add License
                </a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped" id="licensesTable">
                    <thead>
                        <tr>
                            <th width="80">Image</th>
                            <th>Title</th>
                            <th>Subtitle</th>
                            <th>Description Preview</th>
                            <th width="80">Order</th>
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
            $('#licensesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.licenses.data') }}',
                columns: [{
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'subtitle',
                        name: 'subtitle'
                    },
                    {
                        data: 'description_preview',
                        name: 'desc1',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'order',
                        name: 'order'
                    },
                    {
                        data: 'status',
                        name: 'status',
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
                    [4, 'asc']
                ], // Order by 'order' column
                pageLength: 10,
                responsive: true
            });

        });
    </script>
@endpush
