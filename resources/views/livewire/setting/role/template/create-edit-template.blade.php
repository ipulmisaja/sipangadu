<div class="fixed-top h-100 rounded" style="background-color:rgba(0,0,0,.5)">
    <form wire:submit.prevent="{{ $method }}" class="mt-5">
        {{-- modal title --}}
        <div class="w-50 bg-white border-bottom px-5 py-4 mx-auto my-auto rounded-top">
            <span class="h3">{{ $title }}</span>
        </div>
        {{-- modal content --}}
        <div class="w-50 bg-white px-5 py-5 mx-auto my-auto">
            <div class="row">
                <div class="col-3">Nama Role</div>
                <div class="col-9">
                    <input wire:model.lazy="name" type="text" class="form-control">
                    @error('name')
                        <div class="mt-2">
                            <span class="text-danger font-weight-bold">{{ $message }}</span>
                        </div>
                    @enderror
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-3">Deskripsi Role</div>
                <div class="col-9">
                    <input wire:model.lazy="description" type="text" class="form-control">
                    @error('description')
                        <div class="mt-2">
                            <span class="text-danger font-weight-bold">{{ $message }}</span>
                        </div>
                    @enderror
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-3">Warna Dasar</div>
                <div class="col-9">
                    <select class="form-control">
                        <option>- Pilih Salah Satu -</option>
                        <option value="">Primary</option>
                        <option value="">Secondary</option>
                        <option value="">ddll</option>
                    </select>
                </div>
            </div>
        </div>
        {{-- modal footer --}}
        <div class="d-flex w-50 bg-secondary mx-auto my-auto px-5 py-3 rounded-bottom">
            <div class="w-100"></div>
            <button wire:click.prevent="$emit('close')" class="btn btn-icon icon-left btn-danger mr-3">
                <i class="far fa-times-circle"></i>
                BATAL
            </button>
            <button type="submit" class="btn btn-icon icon-left btn-primary">
                <i class="far fa-save"></i>
                SIMPAN
            </button>
        </div>
    </form>
</div>
