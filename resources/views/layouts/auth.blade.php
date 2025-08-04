<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Login Panel - LSP PAMI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('image/logo-kecil-biru.png') }}">
    <!-- Bootstrap CSS (gunakan versi offline/online sesuai kebutuhan) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Icon & Font -->
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- Custom Style -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
        }

        .auth-wrapper {
            min-height: 100vh;
            background-color: #f4f6f9;
        }

        .bg-login {
            background: url("{{ asset('image/bg-3.jpg') }}") no-repeat center center;
            background-size: cover;
            height: 100%;
        }

        .auth-box {
            max-width: 460px;
            width: 100%;
            border-radius: 15px;
        }
    </style>

</head>

<body>

    @yield('content')

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Optional: Toggle password visibility -->
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const passwordInput = document.getElementById("password-input");
        const togglePassword = document.getElementById("toggle-password");
        const eyeIcon = document.getElementById("eye-icon");

        if (passwordInput && togglePassword && eyeIcon) {
            togglePassword.addEventListener("click", function () {
                const type = passwordInput.type === "password" ? "text" : "password";
                passwordInput.type = type;

                // Toggle icon
                eyeIcon.classList.toggle("fa-eye");
                eyeIcon.classList.toggle("fa-eye-slash");
            });
        }
    });
</script>

</body>

</html>
