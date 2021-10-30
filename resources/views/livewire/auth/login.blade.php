@section('title', 'Login')

@section('styles')
<style>
    .separator{display:flex;align-items:center;text-align:center}
    .separator::before,.separator::after{content:'';flex:1;border-bottom: 1px solid #98A6AD}
    .separator::before{margin-right:.25em}
    .separator::after{margin-left:.25em}
</style>
@endsection

<div class="card-body">
    <form wire:submit.prevent="login" class="needs-validation">
        <div class="form-group">
            <label for="username">Username</label>
            <input wire:model="username" type="text" class="form-control" tabindex="1" required autofocus>
            @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="password" class="control-label">Password</label>
            <input wire:model="password" type="password" class="form-control" tabindex="2" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        @error('error')
            <div class="my-3 text-center">
                <span class="text-danger font-weight-bold">{{ $message }}</span>
            </div>
        @enderror
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                Login
            </button>
        </div>
    </form>
</div>
