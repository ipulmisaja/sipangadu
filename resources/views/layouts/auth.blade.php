@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <div class="my-4 py-4">
                    <div class="my-4"></div>
                </div>
                {{-- <div class="login-brand">
                    <img src="{{ secure_asset(env('APP_URL') . 'vendor/stisla/img/stisla-fill.svg') }}" alt="logo" width="100" class="shadow-light rounded-circle">
                </div> --}}
                <div class="card card-primary">
                    <div class="card-header">
                        <div class="mx-auto font-weight-bold">Sistem Pengawasan Anggaran Terpadu</div>
                    </div>
                    @yield('content')
                </div>
                <div class="simple-footer">
                    <p class="text-job text-muted">Dikembangkan Oleh:</p>
                    <img src="{{ secure_asset(env('APP_URL') . 'images/logo.png') }}" class="w-75" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
@overwrite
