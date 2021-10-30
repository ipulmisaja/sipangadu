@section('title', 'Pengajuan Lembur')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

<div class="main-content">
    {{-- Section --}}
    <section class="section" style="z-index:0">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">Pengajuan Lembur</p>
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
                                    <div class="col-3">Tanggal Pengajuan Lembur</div>
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

                                {{-- Nomor Kegiatan --}}
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

                                <div class="row">
                                    <div class="col-12">
                                        <label>Informasi Pegawai yang Akan Melakukan Lembur</label>
                                        <div class="border rounded mt-3">
                                            <div class="card-header">
                                                <button wire:click.prevent="addRow" class="btn btn-icon icon-left btn-primary">
                                                    <i class="fas fa-plus"></i>
                                                    <span class="ml-1">Tambah Pegawai</span>
                                                </button>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        {{-- Column --}}
                                                        <tr>
                                                            <th rowspan="2" class="text-center">Nama Pegawai</th>
                                                            <th rowspan="2" class="text-center">Uraian Pekerjaan</th>
                                                            <th colspan="2" class="text-center">Estimasi Waktu Pelaksanaan Lembur</th>
                                                            <th rowspan="2" class="text-center">Aksi</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">Mulai Jam</th>
                                                            <th class="text-center">Selesai Jam</th>
                                                        </tr>

                                                        {{-- Content --}}
                                                        @foreach ($overtimeList as $index => $personOvertime)
                                                            <tr>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <i class="fas fa-user"></i>
                                                                            </div>
                                                                        </div>
                                                                        <select wire:model="overtimeList.{{ $index }}.employee" class="form-control">
                                                                            <option value="">- Pilih Pegawai -</option>
                                                                            @foreach ($employees as $person)
                                                                                <option value="{{ $person->id }}">{{ $person->nama }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <i class="fas fa-file-alt"></i>
                                                                            </div>
                                                                        </div>
                                                                        <input wire:model="overtimeList.{{ $index }}.description" type="text" class="form-control">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <i class="fas fa-clock"></i>
                                                                            </div>
                                                                        </div>
                                                                        <input wire:model="overtimeList.{{ $index }}.overtimeStart" type="text" class="form-control time">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <i class="fas fa-clock"></i>
                                                                            </div>
                                                                        </div>
                                                                        <input wire:model="overtimeList.{{ $index }}.overtimeEnd" type="text" class="form-control time">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <button wire:click.prevent="deleteRow({{ $index }})" class="btn btn-icon icon-left btn-danger">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-4">

                                {{-- Catatan Kegiatan --}}
                                <div class="row">
                                    <div class="col-3">Dasar Pelaksanaan Lembur</div>
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

    flatpickr('.time', {
        enableTime: true,
        dateFormat: "d-M-Y H:i",
    })

    document.addEventListener('flatpickr', event => {
        flatpickr('.time', {
            enableTime: true,
            dateFormat: "d-M-Y H:i",
        })
    })
</script>
@endpush
