@extends('layouts.app')

@section('content')
    <div class="main-wrapper main-wrapper-1">
        @include('partials.header')

        @include('partials.sidebar')

        <div id="app">
            @yield('inner-content')
        </div>

        @include('partials.footer')
    </div>
@endsection
