@extends('layouts.app')

@section('content')
    <div class="container-fluid py-5">
        <h2 class="modern-title">Data Peserta Pemegang Sertifikat</h2>
        <hr class="modern-hr">
        <div class="col-12 d-flex justify-content-center mb-3">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
            </a>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive p-3 position-relative">
                    <!-- Custom Loading Overlay -->
                    <div id="tableLoadingOverlay" class="table-loading-overlay" style="display: none;">
                        <div class="loading-content">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="mt-2">Memuat data...</div>
                        </div>
                    </div>

                    <table class="table table-bordered" id="asesiFrontendtable">
                        <thead class="table-light text-center">
                            <tr>
                                <th style="width: 10px;">No</th>
                                <th>Nama</th>
                                <th>Skema</th>
                                <th>No. Seri</th>
                                <th>No. Register</th>
                                <th>No. Sertifikat</th>
                                <th>Tanggal Terbit</th>
                                <th>Tanggal Exp</th>
                                <th>Registrasi Nomor</th>
                                <th>Tahun Registrasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- DataTable akan mengisi ini -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Custom DataTable Loading Styles */
        .table-loading-overlay {
            position: absolute !important;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1050;
            border-radius: 8px;
        }

        .loading-content {
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }

        /* DataTables Processing Indicator */
        .dataTables_processing {
            position: absolute !important;
            top: 50% !important;
            left: 50% !important;
            width: 200px !important;
            margin-left: -100px !important;
            margin-top: -25px !important;
            text-align: center !important;
            padding: 15px 20px !important;
            background: rgba(255, 255, 255, 0.95) !important;
            border: 1px solid #dee2e6 !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
            font-size: 14px !important;
            color: #495057 !important;
            z-index: 1051 !important;
        }

        /* Custom Spinner Animation */
        .custom-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(0, 123, 255, 0.3);
            border-radius: 50%;
            border-top-color: #007bff;
            animation: spin 1s ease-in-out infinite;
            margin-right: 10px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Ensure table container has relative positioning */
        .table-responsive {
            position: relative;
        }

        /* DataTable wrapper positioning */
        .dataTables_wrapper {
            position: relative;
        }

        /* Loading state for table */
        .table-loading .table {
            opacity: 0.5;
            pointer-events: none;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .dataTables_processing {
                width: 150px !important;
                margin-left: -75px !important;
                padding: 10px 15px !important;
                font-size: 12px !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(function() {
            // Initialize DataTable with enhanced loading
            const table = $('#asesiFrontendtable').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    processing: '<div class="custom-spinner"></div>Memuat data...',
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "Data tidak ditemukan",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    search: "Cari:",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                },
                ajax: {
                    url: '{{ route('asesi.data') }}',
                    data: function(d) {
                        d.nama = $('#filterNama').val();
                        d.tanggal_terbit = $('#filterTanggal').val();
                    },
                    beforeSend: function(xhr) {
                        // Show custom loading overlay
                        $('#tableLoadingOverlay').show();
                        $('.table-responsive').addClass('table-loading');
                        console.log('Loading started...');
                    },
                    complete: function(xhr, status) {
                        // Hide custom loading overlay
                        $('#tableLoadingOverlay').hide();
                        $('.table-responsive').removeClass('table-loading');
                        console.log('Loading completed with status:', status);
                    },
                    error: function(xhr, error, thrown) {
                        $('#tableLoadingOverlay').hide();
                        $('.table-responsive').removeClass('table-loading');
                        console.error('DataTable Error:', {
                            error: error,
                            thrown: thrown,
                            status: xhr.status,
                            responseText: xhr.responseText
                        });

                        // Show user-friendly error message
                        if (xhr.status === 500) {
                            alert('Terjadi kesalahan server. Silakan coba lagi.');
                        } else if (xhr.status === 404) {
                            alert('Data tidak ditemukan. Periksa konfigurasi route.');
                        } else {
                            alert('Terjadi kesalahan saat memuat data: ' + error);
                        }
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        render: function(data, type, row) {
                            return data ? data : '-';
                        }
                    },
                    {
                        data: 'sertifikasi',
                        name: 'sertifikasi',
                        render: function(data, type, row) {
                            return data ? data : '-';
                        }
                    },
                    {
                        data: 'no_ser',
                        name: 'no_ser',
                        render: function(data, type, row) {
                            return data ? data : '-';
                        }
                    },
                    {
                        data: 'no_reg',
                        name: 'no_reg',
                        render: function(data, type, row) {
                            return data ? data : '-';
                        }
                    },
                    {
                        data: 'no_sertifikat',
                        name: 'no_sertifikat',
                        render: function(data, type, row) {
                            return data ? data : '-';
                        }
                    },
                    {
                        data: 'tanggal_terbit',
                        name: 'tanggal_terbit',
                        render: function(data, type, row) {
                            if (data && data !== '-' && data !== null) {
                                // Format date if needed
                                try {
                                    const date = new Date(data);
                                    return date.toLocaleDateString('id-ID');
                                } catch (e) {
                                    return data;
                                }
                            }
                            return '-';
                        }
                    },
                    {
                        data: 'tanggal_exp',
                        name: 'tanggal_exp',
                        render: function(data, type, row) {
                            if (data && data !== '-' && data !== null) {
                                try {
                                    const date = new Date(data);
                                    return date.toLocaleDateString('id-ID');
                                } catch (e) {
                                    return data;
                                }
                            }
                            return '-';
                        }
                    },
                    {
                        data: 'registrasi_nomor',
                        name: 'registrasi_nomor',
                        render: function(data, type, row) {
                            return data ? data : '-';
                        }
                    },
                    {
                        data: 'tahun_registrasi',
                        name: 'tahun_registrasi',
                        render: function(data, type, row) {
                            return data ? data : '-';
                        }
                    }
                ],
                // Additional configurations
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                order: [
                    [1, 'asc']
                ],
                responsive: true,
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                    '<"row"<"col-sm-12"tr>>' +
                    '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                drawCallback: function(settings) {
                    console.log('Table redrawn');
                },
                initComplete: function(settings, json) {
                    console.log('DataTable initialized');
                }
            });

            // Event handlers for filters
            $('#filterNama, #filterTanggal').on('change keyup', function() {
                table.ajax.reload();
            });

            // Manual refresh button (if exists)
            $(document).on('click', '#refreshTable', function() {
                table.ajax.reload(null, false); // false = don't reset paging
            });

            // Debug: Check if DataTable CSS is loaded
            console.log('DataTable CSS loaded:', !!$('link[href*="dataTables"]').length);
            console.log('DataTable JS loaded:', typeof $.fn.dataTable !== 'undefined');
        });
    </script>
@endpush
