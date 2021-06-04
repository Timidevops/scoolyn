<!DOCTYPE html>
<html lang="en">
<head>
    @yield('headerMeta')
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/font/stylesheet.css" type="text/css" charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body style="font-family: 'Circular Std'; font-family: 'Circular Std Book'" >
    @yield('topNav')
    @yield('content')

    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.3.5/dist/alpine.min.js" defer></script>
</body>
</html>
