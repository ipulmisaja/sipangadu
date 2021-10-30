@extends('layouts.base')

@section('content')
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>

        {{-- Navbar --}}
        @include('components.layout.navbar')

        {{-- Sidebar --}}
        @include('components.layout.sidebar')

        {{-- Main content --}}
        @yield('content')

        {{-- Footer --}}
        @include('components.layout.footer')
    </div>
@overwrite
