<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon - LSP PAMI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fefefe;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
        }

        .coming-soon-container {
            max-width: 700px;
        }

        .coming-soon-img {
            max-width: 100%;
            height: auto;
            margin-bottom: 30px;
        }

        h1 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: #1e293b;
        }

        p {
            color: #475569;
            font-size: 1.1rem;
        }

        .btn-back {
            background-color: #1e293b;
            color: #fff;
            border-radius: 8px;
            padding: 10px 24px;
            font-weight: 500;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: #334155;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="coming-soon-container row col-12">
        <img src="{{ asset('image/under.jpg') }}" alt="Coming Soon" class="coming-soon-img">
        <a href="{{ route('home') }}" class="btn-back">Kembali ke Beranda</a>
    </div>
</body>
</html>
