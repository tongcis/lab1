<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon" />
    <title>Laboratorium FST UPY{{ isset($title) ? ' | ' . $title : '' }}</title>
    @vite([])
    @include('layouts.user.ext-css')
    @stack('css')
</head>

<body>
    <script src="{{ asset('dist/js/demo-theme.min.js') }}"></script>
    <div class="page">
        <!-- Navbar -->
        @include('layouts.user.navbar')
        <div class="page-wrapper">
            @yield('content')
            @include('layouts.user.footer')
        </div>
    </div>

    @include('layouts.user.ext-js')
    @stack('js')
</body>

</html>
