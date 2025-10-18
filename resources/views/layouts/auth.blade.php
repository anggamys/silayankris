<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KEBAYAPAIS')</title>
    @vite(['resources/js/app.js', 'resources/scss/app.scss'])
</head>

<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        @yield('content')
    </div>
</body>

</html>
