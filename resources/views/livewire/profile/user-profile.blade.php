<img alt="image"
    @if(is_null($foto))
        src="{{ secure_asset(env('APP_URL') . 'vendor/stisla/img/avatar/avatar-1.png') }}"
    @else
        src="{{ $foto }}"
    @endif
    class="rounded-circle mr-1">

<div class="d-sm-none d-lg-inline-block">{{ $nama }}</div>
