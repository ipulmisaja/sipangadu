<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Title --}}
    <title>@yield('title') - {{ config('app.name') }}</title>

    {{-- Trix Editor --}}
    <link rel="stylesheet" href="https://unpkg.com/trix@1.3.1/dist/trix.css">

    {{-- Stisla Assets --}}
    <link rel="stylesheet" href="{{ secure_asset(env('APP_URL') . 'vendor/stisla/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ secure_asset(env('APP_URL') . 'vendor/stisla/modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ secure_asset(env('APP_URL') . 'vendor/stisla/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ secure_asset(env('APP_URL') . 'vendor/stisla/css/components.min.css') }}">

    {{-- Custom Style --}}
    @yield('styles')

    {{-- Fonts --}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{-- Livewire Assets --}}
    @livewireStyles

    {{-- Custom for Turbolinks --}}
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet" data-turbolinks-track="true"> --}}
    {{-- <script src="{{ asset('js/app.js') }}" defer data-turbolinks-track="true"></script> --}}
</head>
<body>
    <div id="app">
        @yield('content')
    </div>

    @livewireScripts

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://unpkg.com/trix@1.3.1/dist/trix.js"></script>
    <script src="{{ secure_asset(env('APP_URL') . 'vendor/stisla/modules/jquery.min.js') }}"></script>
    <script src="{{ secure_asset(env('APP_URL') . 'vendor/stisla/modules/popper.js') }}"></script>
    <script src="{{ secure_asset(env('APP_URL') . 'vendor/stisla/modules/tooltip.js') }}"></script>
    <script src="{{ secure_asset(env('APP_URL') . 'vendor/stisla/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ secure_asset(env('APP_URL') . 'vendor/stisla/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ secure_asset(env('APP_URL') . 'vendor/stisla/modules/moment.min.js') }}"></script>
    <script src="{{ secure_asset(env('APP_URL') . 'vendor/stisla/js/stisla.js') }}"></script>
    <script src="{{ secure_asset(env('APP_URL') . 'vendor/stisla/js/scripts.js') }}"></script>
    <script src="{{ secure_asset(env('APP_URL') . 'vendor/stisla/js/custom.js') }}"></script>

    @stack('scripts')
</body>
</html>
