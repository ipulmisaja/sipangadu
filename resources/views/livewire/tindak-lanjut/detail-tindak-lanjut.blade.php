@section('title', $activityGroup[0]->reference_id)

<div class="main-content">
    {{-- Section --}}
    <section class="section" style="z-index:0">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">Tindak Lanjut Pengajuan Belanja</p>
        </div>

        {{-- Body --}}
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">
                        <div class="card-header bg-light">
                            <span style="font-size: 1.5rem">Informasi Utama</span>
                        </div>
                        <div class="card-body">
                            @php
                                $relationship = getModelRelationship($activityGroup[0]->reference_id)['relationship'];
                            @endphp

                            {{-- Nama dan Nomor Kegiatan --}}
                            <div class="form-group">
                                <p class="h6 font-weight-bold">
                                    <i class="fas fa-sticky-note"></i>
                                    <span class="ml-1">Informasi Kegiatan</span>
                                </p>
                                <ul class="ml-4">
                                    <li>Tanggal Pengajuan : <b>{{ DateFormat::convertDateTime($relationship->pemeriksaanRelationship->tanggal_pengajuan) }}</b></li>
                                    <li>Nomor Pengajuan Kegiatan : <b>{{ $relationship->pemeriksaanRelationship->nomor_pengajuan }}</b></li>
                                    <li>Nama Kegiatan : <b>{{ $relationship->pemeriksaanRelationship->nama }}</b></li>
                                </ul>
                            </div>
                            <hr>

                            {{-- Kode dan Deskripsi Anggaran --}}
                            <div class="form-group">
                                <p class="h6 font-weight-bold">
                                    <i class="fas fa-coins"></i>
                                    <span class="ml-1">Pagu Kegiatan</span>
                                </p>
                                <ul class="ml-4">
                                    <li>
                                        Kode Anggaran :
                                        <span class="text-primary font-weight-bold">
                                            {{
                                                '054.01.' .
                                                $relationship->pokRelationship->kd_program . "." .
                                                $relationship->pokRelationship->kd_kegiatan . "." .
                                                $relationship->pokRelationship->kd_kro . "." .
                                                $relationship->pokRelationship->kd_ro . "." .
                                                $relationship->pokRelationship->kd_komponen . "." .
                                                $relationship->pokRelationship->kd_subkomponen . "." .
                                                $relationship->pokRelationship->kd_akun . "." .
                                                $relationship->pokRelationship->kd_detail
                                            }}
                                        </span>
                                    </li>
                                    <li>
                                        Deskripsi Anggaran : <b>{{ $relationship->pokRelationship->deskripsi }}</b>
                                    </li>
                                    <li>
                                        Pada Kegiatan : <b>{{ \App\Models\Pok::where('pakai', true)->where('kd_kegiatan', $relationship->pokRelationship->kd_kegiatan)->where('kd_kro', '000')->first('deskripsi')->deskripsi }}</b>
                                    </li>
                                </ul>
                            </div>
                            <hr>

                            {{-- Volume Kegiatan --}}
                            <div class="form-group">
                                <p class="h6 font-weight-bold">
                                    <i class="fas fa-archive"></i>
                                    <span class="ml-1">Anggaran dan Volume Kegiatan</span>
                                </p>
                                <ul class="ml-4">
                                    <li>
                                        Anggaran yang akan digunakan sebesar <b>Rp. {{ number_format($relationship->total, 0, ',', '.') }},-</b> dari sisa anggaran sebesar <b>Rp. {{ number_format($availableBudget, 0, ',', '.') }},-</b>
                                    </li>
                                    <li>
                                        Volume kegiatan yang akan digunakan sebesar <b>{{ $relationship->volume . ' ' . $satuan }}</b> dari sisa volume kegiatan sebesar <b>{{ $availableVolume . ' ' . $satuan }}</b>
                                    </li>
                                </ul>
                            </div>
                            <hr>

                        {{-- Daftar Orang Perjalanan Dinas --}}
                        <div class="form-group">
                            <p class="h6 font-weight-bold">
                                <i class="fas fa-users"></i>
                                <span class="ml-1">Daftar Pegawai yang Akan Melakukan Perjalanan Dinas</span>
                            </p>
                            <div class="ml-4 mt-3">
                                <div class="table-responsive border rounded">
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th>Nama Pegawai</th>
                                            <th>Tempat Tujuan Perjalanan Dinas</th>
                                            <th>Tanggal Pelaksanaan Perjalanan Dinas</th>
                                            <th>Lama Perjalanan Dinas</th>
                                        </tr>

                                        @foreach ($relationship->detailPerjalananDinasRelationship as $item)
                                            <tr>
                                                <td>
                                                    {{ \App\Models\User::where('id', $item->user_id)->first('nama')->nama }}
                                                </td>
                                                <td>
                                                    {{ $item->tujuan }}
                                                </td>
                                                <td>
                                                    {{ DateFormat::convertDateTime($item->tanggal_berangkat) }} s/d
                                                    {{ DateFormat::convertDateTime($item->tanggal_kembali) }}
                                                </td>
                                                <td>
                                                    {{
                                                        \Carbon\Carbon::parse($item->tanggal_kembali, 'UTC')->diffInDays(\Carbon\Carbon::parse($item->tanggal_berangkat, 'UTC')) + 1
                                                    }} hari
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>

                        {{-- Unduh Berkas --}}
                        <div class="form-group">
                            <p class="h6 font-weight-bold">
                                <i class="fas fa-search"></i>
                                <span class="ml-2">Unduh Berkas</span>
                            </p>
                            <a
                                href="{{ route('pdf.generate', ['id' => $perjadin->reference_id]) }}"
                                class="ml-4 mt-2 btn btn-icon icon-left btn-info">
                                <i class="fa fa-download"></i>
                                <span class="ml-1">Unduh</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
