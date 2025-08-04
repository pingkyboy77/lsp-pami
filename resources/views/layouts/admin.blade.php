<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - LSP PAMI</title>
    <link rel="shortcut icon" href="{{ asset('image/logo-kecil-biru.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/46.0.0/ckeditor5.css" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fc;
            line-height: 1.6;
        }


        /* Sidebar */
        .sidebar {
            background: linear-gradient(to right, #283593, #2196F3);
            color: white;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
        }

        .sidebar a:hover,
        .sidebar .nav-link.active {
            background-color: #5C6BC0;
            color: #fff;
        }



        /* Show sidebar permanently on desktop */
        @media (min-width: 992px) {
            .sidebar-desktop {
                display: block !important;
                position: fixed;
                top: 0;
                left: 0;
                width: 250px;
                height: 100vh;
                z-index: 1000;
                overflow-y: auto;
            }

            .main-content {
                margin-left: 250px;
            }
        }

        /* Mobile sidebar stays offcanvas */
        @media (max-width: 991.98px) {
            .sidebar-desktop {
                display: none !important;
            }
        }

        table.dataTable {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            font-size: 0.95rem;
        }

        table.dataTable tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
    </style>
    @stack('styles')
    <!-- Tambahkan di <head> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <!-- Sidebar: Mobile (offcanvas) -->
    <div class="offcanvas offcanvas-start sidebar" tabindex="-1" id="sidebarMobile">
        <div class="offcanvas-header">
            <h5 class="text-white">Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            @include('partials.sidebar-links')
        </div>
    </div>

    <!-- Sidebar: Desktop (fixed) -->
    <div class="sidebar sidebar-desktop d-none d-lg-block">
        @include('partials.sidebar-links')
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg px-4 py-3 shadow text-white"
            style="background: linear-gradient(to right, #283593, #2196F3);">
            <!-- Mobile toggle -->
            <button class="btn btn-outline-secondary d-lg-none me-2" data-bs-toggle="offcanvas"
                data-bs-target="#sidebarMobile">
                ☰
            </button>
            <h6 class="navbar-brand m-0 text-light">Admin Panel</h6>

            <div class="ms-auto dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    {{ Auth::user()->name }} ({{ Auth::user()->role }})
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">Profil</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="p-4">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables -->

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


    <script>
        $(function() {
            const passwordInput = $('#password-input');
            const passwordNote = $('#password-note');

            // Toggle mata
            $(document).on('click', '#toggle-password', function() {
                const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
                passwordInput.attr('type', type);
                $('#eye-icon').toggleClass('fa-eye fa-eye-slash');
            });

            // Saat buka modal
            $('#addUser').on('click', function() {
                passwordInput.prop('required', true);
                passwordInput.attr('minlength', 8);
                passwordNote.text('Password minimal 8 karakter');
            });

            $(document).on('click', '.editUser', function() {
                const id = $(this).data('id');
                $.get('/admin/users/' + id + '/edit', function(data) {
                    $('#userId').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#role').val(data.role);

                    // Untuk edit, password boleh kosong
                    passwordInput.prop('required', false);
                    passwordInput.val('');
                    passwordNote.text('Kosongkan jika tidak ingin mengubah password');

                    $('#userModal').modal('show');
                });
            });
        });
    </script>
    <script>
        $(document).on('click', '.btn-delete', function() {
            const url = $(this).data('url');
            $('#formDelete').attr('action', url);
            $('#modalDelete').modal('show');
        });
    </script>


    <script src="https://cdn.tiny.cloud/1/ja6oqoqenbnly6w4bby50057y7prin951kc60x399tb0x045/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script src="https://cdn.tiny.cloud/1/ja6oqoqenbnly6w4bby50057y7prin951kc60x399tb0x045/tinymce/8/tinymce.min.js"
        referrerpolicy="origin" crossorigin="anonymous"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const editorElement = document.getElementById('editor');
            if (editorElement) {
                tinymce.init({
                    selector: '#editor',
                    height: 400,
                    plugins: 'image link lists table code fullscreen preview media',
                    toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table | code fullscreen',

                    // Konfigurasi upload image
                    automatic_uploads: true,
                    images_upload_url: '{{ route('admin.uploadImage') }}',
                    images_upload_credentials: true,

                    // Pengaturan URL
                    relative_urls: false,
                    remove_script_host: false,
                    convert_urls: true,

                    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',

                    // Handler upload image yang diperbaiki
                    images_upload_handler: function(blobInfo, success, failure, progress) {
                        const formData = new FormData();
                        formData.append('file', blobInfo.blob(), blobInfo.filename());

                        // HARUS mengembalikan Promise untuk TinyMCE
                        return new Promise((resolve, reject) => {
                            fetch('{{ route('admin.uploadImage') }}', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json',
                                    },
                                    body: formData,
                                    credentials: 'same-origin'
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error(
                                            `HTTP error! status: ${response.status}`);
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    console.log('Upload response:', data); // Debug log
                                    if (data.location) {
                                        success(data.location);
                                        resolve(data.location);
                                    } else {
                                        const errorMsg = 'Upload failed: ' + (data.error ||
                                            'Unknown error');
                                        failure(errorMsg);
                                        reject(new Error(errorMsg));
                                    }
                                })
                                .catch(error => {
                                    console.error('Upload error:', error);
                                    const errorMsg = 'Upload failed: ' + error.message;
                                    failure(errorMsg);
                                    reject(error);
                                });
                        });
                    },

                    // Konfigurasi tambahan untuk dialog image
                    image_title: true,
                    image_description: false,
                    image_dimensions: false,
                    image_class_list: [{
                            title: 'Responsive',
                            value: 'img-responsive'
                        },
                        {
                            title: 'Rounded',
                            value: 'img-rounded'
                        }
                    ],

                    // Error handling
                    init_instance_callback: function(editor) {
                        console.log('TinyMCE initialized for:', editor.id);
                    }
                });
            } else {
                console.error('Editor element with ID "editor" not found');
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
