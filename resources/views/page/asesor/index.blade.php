@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h2 class="modern-title">Data Asesor Kompetensi</h2>
        <hr class="modern-hr p-0">
        <div class="col-12 d-flex justify-content-center mb-3">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
                </a>
            </div>
        {{-- </div> --}}

        <div class="card">
            
            @include('partials.alert')
            <div class="table-responsive p-3">
                <table class="table table-bordered table-hover align-middle shadow-sm " id="asesorFrontendtable">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th style="width: 50px;">No</th>
                            <th>Nama</th>
                            <th>Nomor MET</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>


        {{-- <div class="mt-4 d-flex justify-content-start">
        <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary rounded-pill px-4">← Kembali</a>
    </div> --}}
    </div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#asesorFrontendtable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('asesor.data') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'nomor_met',
                        name: 'nomor_met'
                    },
                ]
            });
        });
    </script>
@endpush
