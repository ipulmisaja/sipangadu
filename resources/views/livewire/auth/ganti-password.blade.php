<div class="fixed-top h-100 rounded pt-5" style="background-color:rgba(0,0,0,.5)">
    <form wire:submit.prevent="save" class="mt-5">
        {{-- modal title --}}
        <div class="w-50 bg-white border-bottom px-5 py-4 mx-auto my-auto rounded-top">
            <span class="h3">Ganti kata sandi.</span>
        </div>
        {{-- modal content --}}
        <div class="w-50 bg-white px-5 py-5 mx-auto my-auto">
            <div class="row">
                <div class="col-3">Kata Sandi Baru</div>
                <div class="col-9">
                    <input wire:model="password" type="password" class="form-control">
                    @error('password')
                        <div class="mt-2">
                            <span class="text-danger">{{ $message }}</span>
                        </div>
                    @enderror
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-3">Ulangi Kata Sandi</div>
                <div class="col-9">
                    <input wire:model="passwordKonfirmasi" type="password" class="form-control">
                    @error('passwordConfirmation')
                        <div class="mt-2">
                            <span class="text-danger">{{ $message }}</span>
                        </div>
                    @enderror
                </div>
            </div>
        </div>
        {{-- modal footer --}}
        <div class="d-flex w-50 bg-secondary mx-auto my-auto px-5 py-3 rounded-bottom">
            <div class="w-100"></div>
            <button type="submit" class="btn btn-icon icon-left btn-primary">
                <i class="far fa-save"></i>
                SIMPAN
            </button>
        </div>
    </form>
</div>
