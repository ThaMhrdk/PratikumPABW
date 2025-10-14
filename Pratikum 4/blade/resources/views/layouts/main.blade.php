<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TelU Well</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa;">

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #b71c1c;">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/telkom-logo.png') }}" alt="TelU Well" width="30" class="me-2">
                TelU Well
            </a>
            <div class="ms-auto">
                <a href="{{ route('dashboard') }}" class="text-white me-3 text-decoration-none">Dashboard</a>
                <a href="#" class="text-white text-decoration-none">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="card shadow p-4">
            @yield('content')
        </div>
    </div>

</body>
</html>
