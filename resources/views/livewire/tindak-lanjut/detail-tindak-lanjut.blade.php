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
                                    <li>Tanggal Pengajuan : <b>{{ DateFormat::convertDateTime($activityGroup[0]->$relationship->tanggal_pengajuan) }}</b></li>
                                    <li>Nomor Pengajuan Kegiatan : <b>{{ $activityGroup[0]->$relationship->nomor_pengajuan }}</b></li>
                                    <li>Nama Kegiatan : <b>{{ $activityGroup[0]->$relationship->nama }}</b></li>
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
                                                $activityGroup[0]->$relationship->pokRelationship->kd_program . "." .
                                                $activityGroup[0]->$relationship->pokRelationship->kd_kegiatan . "." .
                                                $activityGroup[0]->$relationship->pokRelationship->kd_kro . "." .
                                                $activityGroup[0]->$relationship->pokRelationship->kd_ro . "." .
                                                $activityGroup[0]->$relationship->pokRelationship->kd_komponen . "." .
                                                $activityGroup[0]->$relationship->pokRelationship->kd_subkomponen . "." .
                                                $activityGroup[0]->$relationship->pokRelationship->kd_akun . "." .
                                                $activityGroup[0]->$relationship->pokRelationship->kd_detail
                                            }}
                                        </span>
                                    </li>
                                    <li>
                                        Deskripsi Anggaran : <b>{{ $activityGroup[0]->$relationship->pokRelationship->deskripsi }}</b>
                                    </li>
                                    <li>
                                        Pada Kegiatan : <b>{{ \App\Models\Pok::where('pakai', true)->where('kd_kegiatan', $activityGroup[0]->$relationship->pokRelationship->kd_kegiatan)->where('kd_kro', '000')->first('deskripsi')->deskripsi }}</b>
                                    </li>
                                </ul>
                            </div>
                            <hr>

                            {{-- Volume Kegiatan --}}
                            @if ($relationship === 'paketMeetingRelationship' || $relationship === 'perjadinRelationship')
                                <div class="form-group">
                                    <p class="h6 font-weight-bold">
                                        <i class="fas fa-archive"></i>
                                        <span class="ml-1">Anggaran dan Volume Kegiatan</span>
                                    </p>
                                    <ul class="ml-4">
                                        <li>
                                            Anggaran yang akan digunakan sebesar <b>Rp. {{ number_format($activityGroup[0]->$relationship->total, 0, ',', '.') }},-</b> dari sisa anggaran sebesar <b>Rp. {{ number_format($budgetTemp, 0, ',', '.') }},-</b>
                                        </li>
                                        <li>
                                            Volume kegiatan yang akan digunakan sebesar <b>{{ $activityGroup[0]->$relationship->volume . ' ' . $satuanTemp }}</b> dari sisa volume kegiatan sebesar <b>{{ $volumeTemp . ' ' . $satuanTemp }}</b>
                                        </li>
                                    </ul>
                                </div>
                                <hr>
                            @endif

                            {{-- Daftar Orang Lembur --}}
                            @if ($relationship === 'lemburRelationship')
                                <div class="form-group">
                                    <p class="h6 font-weight-bold">
                                        <i class="fas fa-users"></i>
                                        <span class="ml-1">Daftar Pegawai yang Akan Melakukan Lembur</span>
                                    </p>
                                    <div class="ml-4 mt-3">
                                        <div class="table-responsive border rounded">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th rowspan="2" class="text-center">Nama Pegawai</th>
                                                    <th rowspan="2" class="text-center">Uraian Pekerjaan</th>
                                                    <th rowspan="2" class="text-center">Tanggal Lembur</th>
                                                    <th colspan="3" class="text-center">Estimasi Waktu Pelaksanaan Lembur</th>
                                                </tr>
                                                <tr>
                                                    <th class="text-center">Mulai Jam</th>
                                                    <th class="text-center">Selesai Jam</th>
                                                    <th class="text-center">Durasi (Jam)</th>
                                                </tr>
                                                @foreach ($activityGroup[0]->$relationship->detailLemburRelationship as $item)
                                                    @if($loop->odd)
                                                        <tr style="background-color: rgba(0,0,0,.03)">
                                                            <td>
                                                                {{ \App\Models\User::where('id', $item->user_id)->first('nama')->nama }}
                                                            </td>
                                                            <td>
                                                                {{ $item->deskripsi }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ DateFormat::convertDateTime($item->tanggal_mulai) }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ \Carbon\Carbon::parse($item->tanggal_mulai)->toTimeString() }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ \Carbon\Carbon::parse($item->tanggal_berakhir)->toTimeString() }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $item->durasi }} Jam
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td>
                                                                {{ \App\Models\User::where('id', $item->user_id)->first('nama')->nama }}
                                                            </td>
                                                            <td>
                                                                {{ $item->deskripsi }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ DateFormat::convertDateTime($item->tanggal_mulai) }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ \Carbon\Carbon::parse($item->tanggal_mulai)->toTimeString() }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ \Carbon\Carbon::parse($item->tanggal_berakhir)->toTimeString() }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $item->durasi }} Jam
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{--  Daftar Orang Perjalanan Dinas --}}
                            @if ($relationship === 'perjadinRelationship')
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

                                                @foreach ($activityGroup[0]->$relationship->detailPerjalananDinasRelationship as $item)
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
                            @endif

                            {{-- Unduh/Preview Berkas --}}
                            <div class="form-group">
                                <p class="h6 font-weight-bold">
                                    <i class="fas fa-download"></i>
                                    <span class="ml-2">
                                        @switch($relationship)
                                            @case('paketMeetingRelationship')
                                                Preview Berkas
                                                @break
                                            @default
                                                Unduh Berkas
                                        @endswitch
                                    </span>
                                </p>
                                @switch($relationship)
                                    @case('paketMeetingRelationship')
                                        <iframe class="ml-4 mt-2" src="{{ google_view_file($activityGroup[0]->$relationship->file) }}" width="98%" height="600px"></iframe>
                                        @break
                                    @default
                                    <a
                                        href="{{ route('pdf.generate', ['id' => $activityGroup[0]->reference_id]) }}"
                                        class="ml-4 mt-2 btn btn-icon icon-left btn-info">
                                            <i class="fa fa-download"></i>
                                            <span class="ml-1">Unduh</span>
                                    </a>
                                @endswitch
                            </div>

                            {{-- Keterangan Tambahan --}}
                            @if(!empty($activityGroup[0]->$relationship->catatan))
                                <hr>
                                <div class="form-group">
                                    <p class="h6 font-weight-bold">
                                        <i class="fas fa-info-circle"></i>
                                        <span class="ml-1">Informasi Tambahan</span>
                                    </p>
                                    <div class="ml-4">{!! $activityGroup[0]->$relationship->catatan !!}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- TODO: perbaikan fitur tindak lanjut --}}
            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">
                        <div class="card-header bg-light">
                            <span style="font-size: 1.5rem">Tindak Lanjut</span>
                        </div>
                        <div class="card-body">
                            @if (auth()->user()->hasUnit('kepeghum'))

                            @elseif (auth()->user()->hasUnit('keuangan'))
                                <div class="form-group">
                                    <p class="h6 font-weight-bold">
                                        <i class="fas fa-download"></i>
                                        <span class="ml-2">Unduh Surat Tugas (belum berfungsi)</span>
                                    </p>
                                    <a
                                        href=""
                                        class="ml-4 mt-2 btn btn-icon icon-left btn-info">
                                        <i class="fa fa-download"></i>
                                        <span class="ml-1">Unduh</span>
                                    </a>
                                </div>
                                <hr>

                                <div class="form-group">
                                    <p class="h6 font-weight-bold">
                                        <i class="fas fa-check-double"></i>
                                        <span class="ml-2">Selesaikan Tindak Lanjut</span>
                                    </p>
                                    <div class="ml-4 custom-control custom-checkbox">
                                        <input
                                            wire:click="followup('{{ $activityGroup[0]->reference_id }}', {{ $activityGroup[0]->status_keuangan }}, 'keuangan')"
                                            type="checkbox"
                                            class="custom-control-input" id="followup"
                                            @if($activityGroup[0]->status_keuangan == 1) checked @endif>
                                        <label class="custom-control-label" for="followup">
                                            {{
                                                $activityGroup[0]->status_keuangan == 0
                                                    ? 'Pengajuan Ini Belum Ditindaklanjuti.'
                                                    : 'Pengajuan Ini Telah Ditindaklanjuti.'
                                            }}
                                        </label>
                                    </div>
                                </div>
                            @elseif (auth()->user()->hasUnit('pengadaan-barjas'))
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
