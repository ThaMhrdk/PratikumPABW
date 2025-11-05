<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Aplikasi Kontak')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding-top: 20px; }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            
            <h2 class="mb-4">@yield('title')</h2>

            @yield('content')

        </div>
    </div>
</div>

</body>
</html>