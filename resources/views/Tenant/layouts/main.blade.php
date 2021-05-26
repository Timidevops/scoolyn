<!DOCTYPE html>
<html lang="en">
<head>
    @yield('headerMeta')
    <link rel="stylesheet" href="/css/app.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
    @yield('topNav')
    @yield('content')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.3.5/dist/alpine.min.js" defer></script>
</body>
</html>
