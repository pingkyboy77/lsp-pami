@extends('layouts.admin')

@section('content')
    <div class="card rounded-4 shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-building"></i> Participants Certificates
            </h4>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.peserta-sertifikat.create') }}" class="btn btn-primary shadow-sm">
                    <i class="bi bi-plus-lg"></i> Add Peserta
                </a>
                <a href="{{ route('admin.peserta-sertifikat.import') }}" class="btn btn-secondary">Import Excel</a>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered" id="pesertaTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Certification</th>
                        {{-- <th>No SER</th> --}}
                        <th>No Reg</th>
                        <th>No Sertifikat</th>
                        <th>Issue Date</th>
                        <th>Expiry Date</th>
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
            $('#pesertaTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.peserta-sertifikat.data') }}',
                columns: [{
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'sertifikasi',
                        name: 'sertifikasi'
                    },
                    {
                        data: 'no_reg',
                        name: 'no_reg'
                    },
                    {
                        data: 'no_sertifikat',
                        name: 'no_sertifikat'
                    },
                    {
                        data: 'tanggal_terbit',
                        name: 'tanggal_terbit'
                    },
                    {
                        data: 'tanggal_exp',
                        name: 'tanggal_exp'
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
