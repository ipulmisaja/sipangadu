@section('title', $lembur->nama)

<div class="main-content">
    {{-- Section --}}
    <section class="section" style="z-index:0">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">Detail Pengajuan Lembur</p>
        </div>

        {{-- Body --}}
        <div class="section-body">
            {{-- Informasi Utama --}}
            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">
                        <div class="card-header bg-light">
                            <span style="font-size: 1.5rem">Informasi Utama</span>
                        </div>
                        <div class="card-body">
                            {{-- Nomor dan Nama Kegiatan --}}
                            <div class="form-group">
                                <p class="h6 font-weight-bold">
                                    <i class="fas fa-sticky-note"></i>
                                    <span class="ml-1">Informasi Kegiatan</span>
                                </p>
                                <ul class="ml-4">
                                    <li>Tanggal Pengajuan : <b>{{ DateFormat::convertDateTime($lembur->tanggal_pengajuan) }}</b></li>
                                    <li>Nomor Pengajuan Kegiatan : <b>{{ $lembur->nomor_pengajuan }}</b></li>
                                    <li>Nama Kegiatan : <b>{{ $lembur->nama }}</b></li>
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
                                                $lembur->pokRelationship->kd_program . "." .
                                                $lembur->pokRelationship->kd_kegiatan . "." .
                                                $lembur->pokRelationship->kd_kro . "." .
                                                $lembur->pokRelationship->kd_ro . "." .
                                                $lembur->pokRelationship->kd_komponen . "." .
                                                $lembur->pokRelationship->kd_subkomponen . "." .
                                                $lembur->pokRelationship->kd_akun . "." .
                                                $lembur->pokRelationship->kd_detail
                                            }}
                                        </span>
                                    </li>
                                    <li>
                                        Deskripsi Anggaran : <b>{{ $lembur->pokRelationship->deskripsi }}</b>
                                    </li>
                                    <li>
                                        Pada Kegiatan : <b>{{ \App\Models\Pok::where('pakai', true)->where('kd_kegiatan', $lembur->pokRelationship->kd_kegiatan)->where('kd_kro', '000')->first('deskripsi')->deskripsi }}</b>
                                    </li>
                                </ul>
                            </div>
                            <hr>

                            {{-- Daftar Orang Lembur --}}
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
                                            @foreach ($lembur->detailLemburRelationship as $item)
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

                            {{-- Unduh Berkas --}}
                            <div class="form-group">
                                <p class="h6 font-weight-bold">
                                    <i class="fas fa-search"></i>
                                    <span class="ml-2">Unduh Berkas</span>
                                </p>
                                <a
                                    href="{{ route('pdf.generate', ['id' => $lembur->reference_id]) }}"
                                    class="ml-4 mt-2 btn btn-icon icon-left btn-info">
                                    <i class="fa fa-download"></i>
                                    <span class="ml-1">Unduh</span>
                                </a>
                            </div>

                            {{-- Keterangan Tambahan --}}
                            @if(!empty($lembur->catatan))
                                <hr>
                                <div class="form-group">
                                    <p class="h6 font-weight-bold">
                                        <i class="fas fa-info-circle"></i>
                                        <span class="ml-1">Informasi Tambahan</span>
                                    </p>
                                    <div class="ml-4">{!! $lembur->catatan !!}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Keterangan Approval --}}
            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">
                        <div class="card-header bg-light">
                            <span style="font-size:1.5rem">Keterangan Pemeriksaan</span>
                        </div>
                        <div class="card-body">
                            {{-- Tahapan Pemeriksaan --}}
                            <div class="form-group">
                                <p class="h6 font-weight-bold">
                                    <i class="fas fa-check-double"></i>
                                    <span class="ml-1">Tahapan Pemeriksaan</span>
                                </p>
                                <div class="ml-4 mt-4">
                                    @include('components.state.approval-on-detail', [
                                        'data' => $lembur->pemeriksaanRelationship->approve_kf,
                                        'name' => 'Koordinator Fungsi',
                                        'date' => $lembur->pemeriksaanRelationship->tanggal_approve_kf
                                    ])

                                    <div class="mt-1"><br></div>

                                    @include('components.state.approval-on-detail', [
                                        'data' => $lembur->pemeriksaanRelationship->approve_ppk,
                                        'name' => 'Pejabat Pembuat Komitmen',
                                        'date' => $lembur->pemeriksaanRelationship->tanggal_approve_ppk
                                    ])

                                    <div class="mt-1"><br></div>

                                    @include('components.state.approval-on-detail', [
                                        'data' => $lembur->pemeriksaanRelationship->approve_kepala,
                                        'name' => 'Kepala BPS Provinsi Sulawesi Barat',
                                        'date' => $lembur->pemeriksaanRelationship->tanggal_approve_kepala
                                    ])
                                </div>
                            </div>
                            <hr>

                            {{-- Hasil Pemeriksaan --}}
                            <div class="form-group">
                                <p class="h6 font-weight-bold">
                                    <i class="fas fa-comments"></i>
                                    <span class="ml-1">Hasil Pemeriksaan</span>
                                </p>
                                <div class="p-3">
                                    @if($comments->count() > 0)
                                        <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
                                            @foreach($comments as $comment)
                                                @if($comment->komentator_tipe == 6)
                                                    @continue
                                                @else
                                                    @if($loop->first)
                                                        <li class="media p-3 border-left border-right border-top rounded-top" style="margin-bottom:0!important">
                                                            <img
                                                                alt="image"
                                                                class="mr-3 rounded-circle"
                                                                src="{{
                                                                    is_null($comment->userRelationship->foto)
                                                                        ? asset('vendor/stisla/img/avatar/avatar-1.png')
                                                                        : $comment->userRelationship->foto
                                                                    }}"
                                                                width="50"
                                                                height="83%"
                                                            >
                                                            <div class="media-body">
                                                                <div class="media-right">
                                                                    @include('components.state.approval-on-comment', [
                                                                        'data' => $comment->status
                                                                    ])
                                                                </div>
                                                                <div class="media-title mb-1">
                                                                    {{ $comment->userRelationship->nama }}
                                                                </div>
                                                                <div class="text-time">
                                                                    <span>
                                                                        <i class="fas fa-user mr-1"></i>
                                                                        @foreach($comment->userRelationship->roles as $role)
                                                                            <span>{{ $role->name }},</span>
                                                                        @endforeach
                                                                        <span>{{ $comment->userRelationship->unitRelationship->nama }}</span>
                                                                    </span>
                                                                    <span class="mx-2"> - </span>
                                                                    <span>
                                                                        <i class="fas fa-calendar mr-1"></i>
                                                                        {{ DateFormat::convertDateTime($comment->tanggal_komentar) }}
                                                                    </span>
                                                                </div>
                                                                <div class="h6 media-description text-muted">
                                                                    {!! $comment->deskripsi !!}
                                                                </div>
                                                            </div>
                                                        </li>
                                                        @elseif($loop->last)
                                                            <li class="media p-3 bg-white border rounded-bottom" style="margin-bottom:0!important">
                                                                <img
                                                                    alt="image"
                                                                    class="mr-3 rounded-circle"
                                                                    src="{{
                                                                        is_null($comment->userRelationship->foto)
                                                                            ? asset('vendor/stisla/img/avatar/avatar-1.png')
                                                                            : $comment->userRelationship->foto
                                                                        }}"
                                                                    width="50"
                                                                    height="83%"
                                                                >
                                                                <div class="media-body">
                                                                    <div class="media-right">
                                                                        @include('components.state.approval-on-comment', [
                                                                            'data' => $comment->status
                                                                        ])
                                                                    </div>
                                                                    <div class="media-title mb-1">
                                                                        {{ $comment->userRelationship->nama }}
                                                                    </div>
                                                                    <div class="text-time">
                                                                        <span>
                                                                            <i class="fas fa-user mr-1"></i>
                                                                            @foreach($comment->userRelationship->roles as $role)
                                                                                <span>{{ $role->name }},</span>
                                                                            @endforeach
                                                                            <span>{{ $comment->userRelationship->unitRelationship->nama }}</span>
                                                                        </span>
                                                                        <span class="mx-2"> - </span>
                                                                        <span>
                                                                            <i class="fas fa-calendar mr-1"></i>
                                                                            {{ DateFormat::convertDateTime($comment->tanggal_komentar) }}
                                                                        </span>
                                                                    </div>
                                                                    <div class="h6 media-description text-muted">
                                                                        {!! $comment->deskripsi !!}
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @else
                                                            <li class="media p-3 bg-white border-left border-right border-top" style="margin-bottom:0!important">
                                                                <img
                                                                    alt="image"
                                                                    class="mr-3 rounded-circle"
                                                                    src="{{
                                                                        is_null($comment->userRelationship->foto)
                                                                            ? asset('vendor/stisla/img/avatar/avatar-1.png')
                                                                            : $comment->userRelationship->foto
                                                                        }}"
                                                                    width="50"
                                                                    height="83%"
                                                                >
                                                                <div class="media-body">
                                                                    <div class="media-right">
                                                                        @include('components.state.approval-on-comment', [
                                                                            'data' => $comment->status
                                                                        ])
                                                                    </div>
                                                                    <div class="media-title mb-1">
                                                                        {{ $comment->userRelationship->nama }}
                                                                    </div>
                                                                    <div class="text-time">
                                                                        <span>
                                                                            <i class="fas fa-user mr-1"></i>
                                                                            @foreach($comment->userRelationship->roles as $role)
                                                                                <span>{{ $role->name }},</span>
                                                                            @endforeach
                                                                            <span>{{ $comment->userRelationship->unitRelationship->nama }}</span>
                                                                        </span>
                                                                        <span class="mx-2"> - </span>
                                                                        <span>
                                                                            <i class="fas fa-calendar mr-1"></i>
                                                                            {{ DateFormat::convertDateTime($comment->tanggal_komentar) }}
                                                                        </span>
                                                                    </div>
                                                                    <div class="h6 media-description text-muted">
                                                                        {!! $comment->deskripsi !!}
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endif
                                                    @endif
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="ml-2">Belum ada catatan pemeriksaan.</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Catatan Rekomendasi --}}
                            @if ($comments->count() === 4)
                                <hr>
                                <div class="form-group">
                                    <p class="h6 font-weight-bold">
                                        <i class="fas fa-comment-alt"></i>
                                        <span class="ml-1">Catatan Rekomendasi Dari Fungsi Perencana</span>
                                    </p>
                                    <div class="p-3">
                                        @foreach ($comments as $comment)
                                            @if($comment->komentator_tipe == 6)
                                                <div class="media border rounded p-3">
                                                    <div class="media-body">
                                                        <div class="media-right">
                                                            @if ($comment->status == 1)
                                                                <span class="badge badge-primary">
                                                                    <i class="fas fa-check-circle"></i>
                                                                    <span class="ml-1">Direkomendasikan</span>
                                                                </span>
                                                            @else
                                                                <span class="badge badge-warning">
                                                                    <i class="fas fa-times-circle"></i>
                                                                    <span class="ml-1">Tidak Direkomendasikan</span>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="h6 media-description w-75">
                                                            {!! $comment->deskripsi !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
