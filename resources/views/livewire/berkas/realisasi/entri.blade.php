@section('title', 'Entri Realisasi')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

<div class="main-content">
    <section class="section" style="z-index:0">
        <div class="section-header">
            <p class="h3">Entri Realisasi Anggaran</p>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <form wire:submit.prevent="save">
                        <div class="card border rounded">
                            <div class="card-header bg-light">
                                <span class="w-100"></span>
                                <div class="reset">
                                    @if (request()->segment(3) !== 'entri')
                                        @if (request()->segment(3) === 'berkas.realisasi.entri')
                                        @elseif ($realisasi->approve_ppk == 0 || $realisasi->approve_ppk == 2)
                                            <button wire:click="truncate({{ $realisasi->id }})" class="btn btn-icon icon-left btn-danger">
                                                <i class="fas fa-history"></i>
                                                <span class="ml-1">Reset</span>
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-3">
                                            Nama Kegiatan
                                        </div>
                                        <div class="col-9">
                                            <input wire:model.lazy="name" type="text" class="form-control" placeholder="-" disabled>
                                            @error('name')
                                                <div class="mt-3">
                                                    <small class="text-danger">{{ $message }}</small>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-3">Pagu Kegiatan</div>
                                        <div class="col-9">
                                            @if (is_null($realisasi))
                                                <label class="text-muted font-weight-bold">Kode Rincian Output</label>
                                                <select wire:model="output" class="form-control">
                                                    <option value='null'>- Pilih Rincian Output -</option>
                                                    @foreach ($outputList as $outputItem)
                                                        <option value="{{ $outputItem->kd_kegiatan . '.' . $outputItem->kd_kro . '.' . $outputItem->kd_ro }}">
                                                            {{
                                                                $outputItem->kd_kegiatan . '.' .
                                                                $outputItem->kd_kro . '.' .
                                                                $outputItem->kd_ro . ' - ' .
                                                                $outputItem->deskripsi
                                                            }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <hr style="border-top:dashed 1px">

                                                <label class="text-muted font-weight-bold">Kode Akun</label>
                                                <select wire:model="account" class="form-control">
                                                    <option value='null'>- Pilih Akun -</option>
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
                                                <hr style="border-top: dashed 1px">

                                                <label class="text-muted font-weight-bold">Detail Anggaran</label>
                                                <select wire:model="detail" class="form-control">
                                                    <option value='null'>- Pilih Detail Anggaran -</option>
                                                    @foreach ($detailList as $detailItem)
                                                        <option value="{{ $detailItem->id }}">
                                                            {{ $detailItem->deskripsi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <hr style="border-top: dashed 1px">
                                                <div>
                                                    <i class="fas fa-cubes"></i>
                                                    <span class="ml-1 font-weight-bold">Volume Tersedia : {{ $availableVolume . " " . $measure }}</span>
                                                </div>
                                                <div class="mt-2">
                                                    <i class="fas fa-coins"></i>
                                                    <span class="ml-1 font-weight-bold">Anggaran Tersedia : Rp. {{ number_format($availableBudget, 0, ',', '.') }},-</span>
                                                </div>
                                            @else
                                                <div class="text-primary font-weight-bold">
                                                    {{
                                                        "054.01." .
                                                        $realisasi->pokRelationship->kd_program . "." .
                                                        $realisasi->pokRelationship->kd_kegiatan . "." .
                                                        $realisasi->pokRelationship->kd_kro . "." .
                                                        $realisasi->pokRelationship->kd_ro . "." .
                                                        $realisasi->pokRelationship->kd_komponen . "." .
                                                        $realisasi->pokRelationship->kd_subkomponen . "." .
                                                        $realisasi->pokRelationship->kd_akun . "." .
                                                        $realisasi->pokRelationship->kd_detail
                                                    }}
                                                </div>
                                                <div>{{ $realisasi->pokRelationship->deskripsi }}</div>
                                                <hr style="border-top: dashed 1px">
                                                <div>
                                                    <i class="fas fa-cubes"></i>
                                                    <span class="ml-1 font-weight-bold">Volume Tersedia : {{ $availableVolume . " " . $measure }}</span>
                                                </div>
                                                <div class="mt-2">
                                                    <i class="fas fa-coins"></i>
                                                    <span class="ml-1 font-weight-bold">Anggaran Tersedia : Rp. {{ number_format($availableBudget, 0, ',', '.') }},-</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-3">Nomor Bukti <small class="badge badge-warning">opsional</small></div>
                                        <div class="col-9">
                                            <input wire:model.lazy="spmNumber" type="text" class="form-control">
                                            @error('spmNumber')
                                                <div class="mt-3">
                                                    <small class="text-danger">{{ $message }}</small>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-3">Tanggal Bukti <small class="badge badge-warning">opsional</small></div>
                                        <div class="col-9">
                                            <input wire:model.lazy="spmDate" type="text" class="form-control date" placeholder="Contoh: 08-Jun-2021">
                                            @error('spmDate')
                                                <div class="mt-3">
                                                    <small class="text-danger">{{ $message }}</small>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                {{-- Realisasi Volume --}}
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-3">Jumlah Realisasi Volume</div>
                                        <div class="col-9">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <small>{{ $measure }}</small>
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
                                <hr>

                                {{-- Realisasi Anggaran --}}
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-3">Jumlah Realisasi Anggaran</div>
                                        <div class="col-9">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <small>Rp.</small>
                                                    </div>
                                                </div>
                                                <input wire:model.lazy="total" type="text" class="form-control">
                                            </div>
                                            @error('total')
                                                <div class="mt-2">
                                                    <label class="text-danger font-weight-bold">{{ $message }}</label>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                @if (!is_null($realisasi->total) && !is_null($realisasi->volume))
                                    @if ($realisasi->approve_ppk == 0 || $realisasi->approve_ppk == 2)
                                    <hr>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-3">Informasi Entri (Sementara)</div>
                                                <div class="col-9">
                                                    <ol>
                                                        <li>Volume Realisasi : {{ $realisasi->volume . " " . $measure }}</li>
                                                        <li>Total Realisasi : {{ number_format($realisasi->total, 0, ',', '.') }}</li>
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <div class="card-footer bg-secondary">
                                <button class="btn btn-icon icon-left btn-primary float-right">
                                    <i class="fas fa-save"></i>
                                    <span class="ml-1">Simpan</span>
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
    flatpickr('.date', {
        dateFormat: "d-M-Y"
    })
</script>
@endpush
