@section('title', 'Pok Tahun ' . $year)

<div class="main-content">
    {{-- Section --}}
    <section class="section" style="z-index:0">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">Petunjuk Operasional Kegiatan Tahun {{ $year }} Revisi Ke - {{ $version }}</p>
        </div>

        {{-- Body --}}
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">
                        {{-- Card Header --}}
                        <div class="border-bottom p-4">
                            <div class="row">
                                <div class="col-2 font-weight-bold">Kode Kegiatan : </div>
                                <div class="col-10">
                                    <select wire:model="activity" class="form-control">
                                        <option value="null">- Seluruh Kegiatan -</option>
                                        @foreach ($activityList as $pagu)
                                            <option value="{{
                                                $pagu->kd_departemen . "." .
                                                $pagu->kd_organisasi . "." .
                                                $pagu->kd_program . "." .
                                                $pagu->kd_kegiatan
                                            }}">
                                                {{
                                                    $pagu->kd_departemen . "." .
                                                    $pagu->kd_organisasi . "." .
                                                    $pagu->kd_program . "." .
                                                    $pagu->kd_kegiatan . " - " .
                                                    $pagu->deskripsi
                                                }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="row">
                                <div class="col-2 font-weight-bold">Kode Rincian Output :</div>
                                <div class="col-10">
                                    <select wire:model="ro" class="form-control">
                                        <option value="null">- Seluruh Rincian Output -</option>
                                        @foreach ($roList as $pagu)
                                            <option value="{{
                                                $pagu->kd_kegiatan . "." .
                                                $pagu->kd_kro . "." .
                                                $pagu->kd_ro
                                            }}">
                                                {{
                                                    $pagu->kd_kegiatan . "." .
                                                    $pagu->kd_kro . "." .
                                                    $pagu->kd_ro . " - " .
                                                    $pagu->deskripsi
                                                }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <small>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            {{-- Columns --}}
                                            <tr class="bg-dark text-white">
                                                <th>Kode</th>
                                                <th>Uraian</th>
                                                <th>Volume</th>
                                                <th>Harga Satuan</th>
                                                <th>Jumlah</th>
                                                <th>Realisasi Volume</th>
                                                <th>Sisa Volume</th>
                                                <th>Realisasi Anggaran</th>
                                                <th>Sisa Anggaran</th>
                                            </tr>

                                            {{-- Content --}}
                                            @foreach ($pok as $item)
                                                {{-- TODO: Kode Program Sum Jumlah --}}
                                                @if($item->kd_kegiatan === '0000')
                                                    <tr class="font-weight-bold bg-success text-black">
                                                        <td>
                                                            {{
                                                                $item->kd_departemen . '.' .
                                                                $item->kd_organisasi . '.' .
                                                                $item->kd_program
                                                            }}
                                                        </td>
                                                        <td>{{ $item->deskripsi }}</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>Rp. {{ number_format($item->total, 0, ',', '.') }},-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>Rp. {{ is_null($item->total_realisasi) ? '-' :  number_format($item->total_realisasi, 0, ',', '.') }},-</td>
                                                        <td>Rp. {{ is_null($item->total_realisasi) ? '-' :  ltrim(number_format(($item->total_realisasi - $item->total), 0, ',', '.'), '-') }},-</td>
                                                    </tr>
                                                {{-- TODO: Kode Kegiatan Sum Jumlah --}}
                                                @elseif($item->kd_kegiatan <> '0000' && $item->kd_kro === '000')
                                                    <tr class="font-weight-bold bg-info" style="color: white">
                                                        <td>{{ $item->kd_kegiatan }}</td>
                                                        <td>{{ $item->deskripsi }}</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>Rp. {{ number_format($item->total, 0, ',', '.') }},-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>Rp. {{ is_null($item->total_realisasi) ? '-' :  number_format($item->total_realisasi, 0, ',', '.') }},-</td>
                                                        <td>Rp. {{ is_null($item->total_realisasi) ? '-' :  ltrim(number_format(($item->total_realisasi - $item->total), 0, ',', '.'), '-') }},-</td>
                                                    </tr>
                                                {{-- TODO: KRO Sum Jumlah --}}
                                                @elseif($item->kd_kro <> '000' && $item->kd_ro === '000')
                                                    <tr class="font-weight-bold bg-danger" style="color: white">
                                                        <td>
                                                            {{
                                                                $item->kd_kegiatan . '.' .
                                                                $item->kd_kro
                                                            }}
                                                        </td>
                                                        <td>{{ $item->deskripsi }}</td>
                                                        <td>{{ $item->volume . ' ' . $item->satuan }}</td>
                                                        <td>-</td>
                                                        <td>Rp. {{ number_format($item->total, 0, ',', '.') }},-</td>
                                                        <td>{{ is_null($item->volume_realisasi) ? '-' : $item->volume_realisasi . ' ' . $item->satuan }}</td>
                                                        <td>{{ is_null($item->volume_realisasi) ? '-' : ltrim(strval(($item->volume_realisasi - $item->volume)), '-') . ' ' . $item->satuan }}</td>
                                                        <td>Rp. {{ is_null($item->total_realisasi) ? '-' :  number_format($item->total_realisasi, 0, ',', '.') }},-</td>
                                                        <td>Rp. {{ is_null($item->total_realisasi) ? '-' :  ltrim(number_format(($item->total_realisasi - $item->total), 0, ',', '.'), '-') }},-</td>
                                                    </tr>
                                                {{-- TODO: RO Sum Jumlah --}}
                                                @elseif($item->kd_ro <> '000' && $item->kd_komponen === '000')
                                                    <tr class="font-weight-bold bg-primary" style="color: white">
                                                        <td>
                                                            {{
                                                                $item->kd_kegiatan . '.' .
                                                                $item->kd_kro . '.' .
                                                                $item->kd_ro
                                                            }}
                                                        </td>
                                                        <td>{{ $item->deskripsi }}</td>
                                                        <td>{{ $item->volume . ' ' . $item->satuan }}</td>
                                                        <td>-</td>
                                                        <td>Rp. {{ number_format($item->total, 0, ',', '.') }},-</td>
                                                        <td>{{ is_null($item->volume_realisasi) ? '-' : $item->volume_realisasi . ' ' . $item->satuan }}</td>
                                                        <td>{{ is_null($item->volume_realisasi) ? '-' : ltrim(strval(($item->volume_realisasi - $item->volume)), '-') . ' ' . $item->satuan }}</td>
                                                        <td>Rp. {{ is_null($item->total_realisasi) ? '-' :  number_format($item->total_realisasi, 0, ',', '.') }},-</td>
                                                        <td>Rp. {{ is_null($item->total_realisasi) ? '-' :  ltrim(number_format(($item->total_realisasi - $item->total), 0, ',', '.'), '-') }},-</td>
                                                    </tr>
                                                {{-- TODO: Komponen Sum Jumlah --}}
                                                @elseif($item->kd_komponen <> '000' && $item->kd_subkomponen === '0' && $item->kd_akun === '000000')
                                                    <tr class="font-weight-bold bg-warning" style="color: white">
                                                        <td>
                                                            {{ $item->kd_komponen }}
                                                        </td>
                                                        <td>{{ $item->deskripsi }}</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>Rp. {{ number_format($item->total, 0, ',', '.') }},-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>Rp. {{ is_null($item->total_realisasi) ? '-' :  number_format($item->total_realisasi, 0, ',', '.') }},-</td>
                                                        <td>Rp. {{ is_null($item->total_realisasi) ? '-' :  ltrim(number_format(($item->total_realisasi - $item->total), 0, ',', '.'), '-') }},-</td>
                                                    </tr>
                                                {{-- TODO: Sub Komponen Sum Jumlah --}}
                                                @elseif($item->kd_komponen <> '000' && $item->kd_subkomponen <> '0' && $item->kd_akun === '000000')
                                                    <tr class="font-weight-bold bg-white" style="color: black">
                                                        <td>
                                                            {{ $item->kd_subkomponen }}
                                                        </td>
                                                        <td>{{ $item->deskripsi }}</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>Rp. {{ number_format($item->total, 0, ',', '.') }},-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>Rp. {{ is_null($item->total_realisasi) ? '-' : number_format($item->total_realisasi, 0, ',', '.') }},-</td>
                                                        <td>Rp. {{ is_null($item->total_realisasi) ? '-' : ltrim(number_format(($item->total_realisasi - $item->total), 0, ',', '.'), '-') }},-</td>
                                                    </tr>
                                                {{-- TODO: Akun Sum Jumlah --}}
                                                @elseif($item->kd_akun <> '000000' && $item->kd_detail === 0)
                                                    <tr class="font-weight-bold bg-secondary">
                                                        <td>{{ $item->kd_akun }}</td>
                                                        <td>{{ $item->deskripsi }}</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>Rp. {{ number_format($item->total, 0, ',', '.') }},-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>Rp. {{ is_null($item->total_realisasi) ? '-' : number_format($item->total_realisasi, 0, ',', '.') }},-</td>
                                                        <td>Rp. {{ is_null($item->total_realisasi) ? '-' : ltrim(number_format(($item->total_realisasi - $item->total), 0, ',', '.'), '-') }},-</td>
                                                    </tr>
                                                @elseif($item->kd_detail !== 0)
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ $item->deskripsi }}</td>
                                                        <td>{{ $item->volume . ' ' . $item->satuan }}</td>
                                                        <td>Rp. {{ number_format($item->harga_satuan, 0, ',', '.') }},-</td>
                                                        <td>Rp. {{ number_format($item->total, 0, ',', '.') }},-</td>
                                                        <td>{{ is_null($item->volume_realisasi) ? '-' : $item->volume_realisasi . ' ' . $item->satuan }}</td>
                                                        <td>{{ is_null($item->volume_realisasi) ? '-' : ltrim(strval(($item->volume_realisasi - $item->volume)), '-') . ' ' . $item->satuan }}</td>
                                                        <td>Rp. {{ is_null($item->total_realisasi) ? '-' : number_format($item->total_realisasi, 0, ',', '.') }},-</td>
                                                        <td>Rp. {{ is_null($item->total_realisasi) ? '-' : ltrim(number_format(($item->total_realisasi - $item->total), 0, ',', '.'), '-') }},-</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
