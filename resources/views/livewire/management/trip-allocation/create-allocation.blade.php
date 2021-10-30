@section('title', 'Buat Alokasi Perjalanan Dinas')

<div class="main-content">
    <section class="section" style="z-index:0">
        <div class="section-header">
            <p class="h3">Buat Alokasi Perjalanan Dinas</p>
        </div>

        <div class="section-body">
            <form wire:submit.prevent="save">
                <div class="bg-white border-left border-top border-right rounded-top">
                    <div class="p-5">
                        {{-- Unit Kerja --}}
                        <div class="row">
                            <div class="col-3">Nama Unit Kerja</div>
                            <div class="col-9">
                                <select wire:model="unitId" class="form-control">
                                    <option value="null">- Pilih Unit Kerja -</option>
                                    <option value="2">Bagian Umum</option>
                                    <option value="3">Fungsi Statistik Sosial</option>
                                    <option value="4">Fungsi Statistik Produksi</option>
                                    <option value="5">Fungsi Statistik Distribusi</option>
                                    <option value="6">Fungsi Neraca Wilayah dan Analisis Statistik</option>
                                    <option value="7">Fungsi Integrasi Pengolahan dan Diseminasi Statistik</option>
                                </select>
                            </div>
                        </div>
                        <hr class="my-4">

                        {{-- Kode dan Deskripsi Anggaran --}}
                        <div class="row">
                            <div class="col-3">Kode dan Deskripsi Anggaran</div>
                            <div class="col-9">
                                <label class="text-muted font-weight-bold">Kode Rincian Output</label>
                                <select wire:model.lazy="output" class="form-control">
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

                                <label class="text-muted font-weight-bold">Kode Akun</label>
                                <select wire:model.lazy="account" class="form-control">
                                    <option value="null">- Pilih Kode Akun -</option>
                                    @foreach ($accountList as $accountItem)
                                        <option value="{{ $accountItem->kd_komponen . '.' .  $accountItem->kd_subkomponen . '.' . $accountItem->kd_akun }}">
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

                                <label class="text-muted font-weight-bold">Detail Anggaran</label>
                                <select wire:model.lazy="detail" class="form-control">
                                    <option value="null">- Pilih Detail Anggaran -</option>
                                    @foreach ($detailList as $detailItem)
                                        <option value="{{ $detailItem->id }}">
                                        {{ $detailItem->deskripsi }}
                                        </option>
                                    @endforeach
                                </select>
                                <hr style="border-top:dashed 1px">

                                <div>
                                    <i class="fas fa-cubes"></i>
                                    <span class="ml-1 font-weight-bold">Volume Tersedia : {{ $availableVolume . ' ' . $measure }}</span>
                                </div>
                                {{-- <div class="mt-2">
                                    <i class="fas fa-coins"></i>
                                    <span class="ml-1 font-weight-bold">Anggaran Tersedia : Rp. {{ $availableBudget }},-</span>
                                </div> --}}
                            </div>
                        </div>
                        <hr class="my-4">

                        {{-- Daftar Nama Pegawai --}}
                        <div class="row">
                            <div class="col-12">
                                <label>Daftar Pegawai</label>
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
                                                <tr>
                                                    <th>Nama Pegawai</th>
                                                    <th>Jumlah (O-P / O-H / O-K)</th>
                                                    <th>Aksi</th>
                                                </tr>

                                                @foreach ($tripAllocationList as $index => $employeeAllocation)
                                                    <tr>
                                                        <td>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">
                                                                        <i class="fas fa-user"></i>
                                                                    </div>
                                                                </div>
                                                                <select wire:model="tripAllocationList.{{ $index }}.employee" class="form-control">
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
                                                                        <small>{{ $measure ?? '-'}}</small>
                                                                    </div>
                                                                </div>
                                                                <input wire:model="tripAllocationList.{{ $index }}.total" type="number" class="form-control">
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
    </section>
</div>
