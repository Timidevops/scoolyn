<!DOCTYPE html>
<html lang="en">
<head>
    @yield('headerMeta')
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/font/stylesheet.css')}}" type="text/css" charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scoolyn</title>
    <style>
        @font-face {
            font-family: "CircularStd-Medium";
            src: url('css/fonts/CircularStd-Medium.ttf') format('truetype');
        }
        @font-face{
            font-family: "CircularStd-Book";
            src:url('css/fonts/CircularStd-Book.ttf') format('truetype');
        }
        @font-face{
            font-family: "CircularStd-Bold";
            src: url('css/fonts/CircularStd-Bold.ttf') format('truetype');
        }
        div.medium,ul.medium{
            font-family:'CircularStd-Medium';
        }
        ul.regular,a.regular,li.regular,div.regular,span.regular,button.regular{
            font-family: "CircularStd-Book";
        }
        div.bold,svg.bold{
            font-family: "CircularStd-Bold";
        }
    </style>
    @livewireStyles
</head>
<body class="medium" >

<div class="h-screen md:flex md:overflow-hidden overflow-scroll bg-purple-100">
    @include('Landlord.partials._sidebar')
    <div class="flex-1 overflow-auto bg-purple-100 focus:outline-none px-4 py-8" tabindex="0" @keydown.escape="showModal = false" @keydown.escape="showSuccess = false" x-cloak id="tab_wrapper">
        <div class="mt-8">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                @yield('pageContent')
            </div>
        </div>
    </div>
</div>

@livewireScripts

<script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@if(\Illuminate\Support\Facades\Session::has('successFlash') || \Illuminate\Support\Facades\Session::has('errorFlash') || \Illuminate\Support\Facades\Session::has('warningFlash'))
    <script>
        @if(\Illuminate\Support\Facades\Session::has('successFlash'))
        swal("Success!", "{{\Illuminate\Support\Facades\Session::get('successFlash')}}", "success");
        @endif
        @if(\Illuminate\Support\Facades\Session::has('errorFlash'))
        swal("Error!", "{{\Illuminate\Support\Facades\Session::get('errorFlash')}}", "error");
        @endif
        @if(\Illuminate\Support\Facades\Session::has('warningFlash'))
        swal("Info!", "{{\Illuminate\Support\Facades\Session::get('warningFlash')}}", "warning");
        @endif
    </script>
@endif

@yield('pageJs')

</body>
</html>
