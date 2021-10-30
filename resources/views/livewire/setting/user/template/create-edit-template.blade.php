<div class="fixed-top h-100 rounded" style="background-color:rgba(0,0,0,.5)">
    <form wire:submit.prevent="{{ $method }}"
        class="{{ $method === 'save' ? 'mt-5' : 'mt-3' }}">
        {{-- modal title --}}
        <div class="w-50 bg-white border-bottom px-5 py-4 mx-auto my-auto rounded-top">
            <span class="h3">{{ $title }}</span>
        </div>
        {{-- modal content --}}
        <div class="w-50 bg-white px-5 py-3 mx-auto my-auto">
            {{-- Nama Pegawai --}}
            <div class="row">
                <div class="col-3">Nama Lengkap</div>
                <div class="col-9">
                    <input wire:model.lazy="name" type="text" class="form-control">
                    @error('name')
                        <div class="mt-2">
                            <span class="text-danger font-weight-bold">{{ $message }}</span>
                        </div>
                    @enderror
                </div>
            </div>
            <hr class="my-3">

            {{-- NIP BPS --}}
            <div class="row">
                <div class="col-3">NIP Lama</div>
                <div class="col-9">
                    <input wire:model.lazy="bpsId" type="number" class="form-control">
                    @error('bpsId')
                        <div class="mt-2">
                            <span class="text-danger font-weight-bold">{{ $message }}</span>
                        </div>
                    @enderror
                </div>
            </div>
            <hr class="my-3">

            {{-- NIP Baru --}}
            <div class="row">
                <div class="col-3">NIP Baru</div>
                <div class="col-9">
                    <input wire:model.lazy="staffId" type="number" class="form-control">
                    @error('staffId')
                        <div class="mt-2">
                            <span class="text-danger font-weight-bold">{{ $message }}</span>
                        </div>
                    @enderror
                </div>
            </div>
            <hr class="my-3">

            {{-- Email BPS  --}}
            <div class="row">
                <div class="col-3">Email BPS</div>
                <div class="col-9">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                        </div>
                        <input wire:model.lazy="email" type="email" class="form-control email">
                        @error('email')
                            <div class="mt-2">
                                <span class="text-danger font-weight-bold">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <hr class="my-3">

            {{-- Kata Sandi --}}
            <div class="row">
                <div class="col-3">Kata Sandi</div>
                <div class="col-9">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-lock"></i></div>
                        </div>
                        <input wire:model.lazy="password" type="password" class="form-control pwstrength" data-indicator="pwindicator">
                        @error('password')
                            <div class="mt-2">
                                <span class="text-danger font-weight-bold">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <hr class="my-3">

            {{-- Pangkat Golongan --}}
            <div class="row">
                <div class="col-3">Pangkat dan Golongan</div>
                <div class="col-9">
                    <select wire:model.lazy="rank_group" class="form-control">
                        <option>- Pilih Pangkat/Golongan -</option>
                        @foreach ($list_rank_group as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                    @if($method === 'update')
                        <span class="badge badge-info mt-2">{{ $selectedRankGroup }}</span>
                    @endif
                </div>
            </div>
            <hr class="my-3">

            {{-- Hak Akses --}}
            <div class="row">
                <div class="col-3">
                    <span>Hak Akses Pengguna</span><br>
                    <span class="text-info">(Role dapat lebih dari satu)</span>
                </div>
                <div class="col-9">
                    <select wire:model="role" class="form-control">
                        <option>- Pilih Role -</option>
                        @foreach ($list_roles as $item)
                            <option value="{{ $item->name }}">{{ $item->description }}</option>
                        @endforeach
                    </select>
                    @if(count($roleArray) > 0)
                        @foreach ($roleArray as $role)
                            <span class="mt-2 badge badge-info">
                                <span class="border-right border-white pr-1 mr-1">
                                    {{ $role }}
                                </span>
                                <span wire:click="deleteRole('{{ $role }}')" role="button" tabindex="0">
                                    &times;
                                </span>
                            </span>
                        @endforeach
                    @endif
                </div>
            </div>
            <hr class="my-3">

            {{-- Unit Kerja --}}
            <div class="row">
                <div class="col-3">Unit Kerja</div>
                <div class="col-9">
                    <select wire:model="unit" class="form-control">
                        <option>- Pilih Unit Kerja -</option>
                        @foreach ($list_unit as $unit_item)
                            <option value="{{ $unit_item->id }}">{{ $unit_item->nama }}</option>
                        @endforeach
                    </select>
                    @if($method === 'update')
                        <span class="badge badge-info mt-2">{{ $selectedUnit }}</span>
                    @endif
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
