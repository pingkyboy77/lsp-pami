@extends('layouts.admin')

@section('content')
    <div class="card rounded-4 shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-building"></i> Asesor
            </h4>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.peserta-sertifikat.create') }}" class="btn btn-primary shadow-sm">
                    <i class="bi bi-plus-lg"></i> Add Asesor
                </a>
                <a href="{{ route('admin.asesor.import') }}" class="btn btn-secondary">Import Excel</a>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered" id="asesortable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>No. MET</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#asesortable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.asesor.data') }}',
                columns: [{
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'nomor_met',
                        name: 'nomor_met'
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
