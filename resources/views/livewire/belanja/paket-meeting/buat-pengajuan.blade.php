@section('title', 'Pengajuan Paket Meeting')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

<div class="main-content">
    {{-- Section --}}
    <section class="section" style="z-index:0">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">Pengajuan Paket Meeting</p>
        </div>

        {{-- Body --}}
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <form wire:submit.prevent="save">
                        <div class="bg-white border-left border-top border-right rounded-top">
                            <div class="p-5">
                                {{-- Tanggal Pengajuan --}}
                                <div class="row">
                                    <div class="col-3">Tanggal Pengajuan Paket Meeting</div>
                                    <div class="col-9">
                                        <input wire:model.lazy="tanggal_pengajuan" type="text" class="form-control tanggal-pengajuan">
                                        @error('tanggal_pengajuan')
                                            <div class="mt-2">
                                                <div class="text-danger font-weight-bold leading">{{ $message }}</div>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <hr class="my-4">

                                {{-- Nomor Nota Dinas --}}
                                <div class="row">
                                    <div class="col-3">Nomor Nota Dinas</div>
                                    <div class="col-9">
                                        <input wire:model.lazy="nota_dinas" type="text" class="form-control">
                                        @error('nota_dinas')
                                            <div class="mt-2">
                                                <label class="text-danger font-weight-bold">{{ $message }}</label>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <hr class="my-4">

                                {{-- Nama Kegiatan --}}
                                <div class="row">
                                    <div class="col-3">Nama Kegiatan</div>
                                    <div class="col-9">
                                        <input wire:model.lazy="nama_kegiatan" type="text" class="form-control">
                                        @error('nama_kegiatan')
                                            <div class="mt-2">
                                                <label class="text-danger font-weight-bold">{{ $message }}</label>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <hr class="my-4">

                                {{-- Kode Deskripsi Anggaran --}}
                                <div class="row">
                                    <div class="col-3">Kode dan Deskripsi Anggaran</div>
                                    <div class="col-9">
                                        {{-- Rincian Output --}}
                                        <label class="text-muted font-weight-bold">Kode Rincian Output</label>
                                        <select wire:model="output" class="form-control">
                                            <option value="null">- Pilih Rincian Output -</option>
                                            @foreach ($outputList as $outputItem)
                                                <option value="{{ $outputItem->kd_kegiatan . '.' . $outputItem->kd_kro . '.' . $outputItem->kd_ro }}">
                                                    {{
                                                        $outputItem->kd_kegiatan . "." .
                                                        $outputItem->kd_kro . "." .
                                                        $outputItem->kd_ro . " - " .
                                                        $outputItem->deskripsi
                                                    }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <hr style="border-top:dashed 1px">

                                        {{-- Akun --}}
                                        <label class="text-muted font-weight-bold">Kode Akun</label>
                                        <select wire:model.lazy="akun" class="form-control">
                                            <option value="null">- Pilih Akun -</option>
                                            @foreach ($accountList as $accountItem)
                                                <option value="{{ $accountItem->kd_komponen . '.' . $accountItem->kd_subkomponen . '.' . $accountItem->kd_akun }}">
                                                    {{
                                                        $accountItem->kd_komponen . '.' .
                                                        $accountItem->kd_subkomponen . '.' .
                                                        $accountItem->kd_akun . ' - ' .
                                                        $accountItem->deskripsi
                                                    }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <hr style="border-top:dashed 1px">

                                        {{-- Detail --}}
                                        <label class="text-muted font-weight-bold">Detail Anggaran</label>
                                        <select wire:model="detail" class="form-control">
                                            <option value='null'>- Pilih Detail Anggaran -</option>
                                            @foreach ($detailList as $detailItem)
                                                <option value="{{ $detailItem->id }}">
                                                    {{ $detailItem->deskripsi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <hr class="my-4">

                                {{-- Anggaran dan Volume --}}
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <p>Anggaran Tersedia</p>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <small>Rp.</small>
                                                    </div>
                                                </div>
                                                <input wire:model="availableBudget" type="text" class="form-control" disabled maxlength="11">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <p>Anggaran yang akan Digunakan</p>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <small>Rp.</small>
                                                    </div>
                                                </div>
                                                <input wire:model.lazy="budget" type="text" class="form-control">
                                            </div>
                                            @error('budget')
                                                <div class="mt-2">
                                                    <label class="text-danger font-weight-bold">{{ $message }}</label>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <p>Volume Tersedia</p>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <small>{{ $satuan }}</small>
                                                    </div>
                                                </div>
                                                <input wire:model="availableVolume" type="text" class="form-control" disabled maxlength="11">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <p>Volume yang akan Digunakan</p>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <small>{{ $satuan }}</small>
                                                    </div>
                                                </div>
                                                <input wire:model.lazy="volume" type="text" class="form-control">
                                            </div>
                                            @error('volume')
                                                <div class="mt-2">
                                                    <label class="text-danger font-weight-bold">{{ $message }}</label>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-4">

                                {{-- Unggah Kelengkapan Administrasi --}}
                                <div class="row">
                                    <div class="col-3">
                                        <span>Unggah Scan Formulir<br>
                                            <b class="text-muted">
                                                <ol>
                                                    <li>File Unggah Dalam Bentuk PDF</li>
                                                    <li>Ukuran Max. 2 MB</li>
                                                </ol>
                                            </b>
                                        </span>
                                        <a href="{{ secure_asset(env('APP_URL') . 'public/template/formulir-fullboard.xlsx') }}" class="btn btn-info">
                                            Unduh Template Formulir
                                        </a>
                                    </div>
                                    <div class="col-9">
                                        <input wire:model.lazy="file" type="file" class="form-control">
                                        @error('file')
                                            <div class="mt-2">
                                                <label class="text-danger font-weight-bold">{{ $message }}</label>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <hr class="my-4">

                                {{-- Catatan --}}
                                <div class="row">
                                    <div class="col-3">Catatan <sup class="badge badge-warning">Opsional</sup></div>
                                    <div class="col-9">
                                        <div wire:ignore x-data @trix-blur="$dispatch('change', $event.target.value)">
                                            <trix-editor wire:model.lazy="catatan" class="form-textarea"></trix-editor>
                                        </div>
                                        @error('catatan')
                                            <div class="mt-2">
                                                <label class="text-danger font-weight-bold">{{ $message }}</label>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="btn-save" class="bg-secondary bg-footer py-3 pr-5 rounded-bottom">
                            <div class="d-flex">
                                <span class="flex-fill"></span>
                                <button class="btn btn-primary">
                                    <i class="far fa-save"></i>
                                    <span>Simpan</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
    flatpickr('.tanggal-pengajuan', {
        dateFormat: "d-M-Y"
    })
</script>
@endpush
