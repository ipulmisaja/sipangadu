@section('title', $perjadin->nama)

<div class="main-content">
    {{-- Section --}}
    <section class="section" style="z-index:0">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">Detail Pengajuan Perjalanan Dinas</p>
        </div>

        {{-- Body --}}
        <div class="section-body">
            {{-- Informasi Utama --}}
            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">
                        <div class="card-header bg-light">
                            <span style="font-size:1.5rem">Informasi Utama</span>
                        </div>
                        <div class="card-body">
                            {{-- Nama dan Nomor Kegiatan --}}
                            <div class="form-group">
                                <p class="h6 font-weight-bold">
                                    <i class="fas fa-sticky-note"></i>
                                    <span class="ml-1">Informasi Kegiatan</span>
                                </p>
                                <ul class="ml-4">
                                    <li>Tanggal Pengajuan : <b>{{ DateFormat::convertDateTime($perjadin->tanggal_pengajuan) }}</b></li>
                                    <li>Nomor Pengajuan Kegiatan : <b>{{ $perjadin->nomor_pengajuan }}</b></li>
                                    <li>Nama Kegiatan : <b>{{ $perjadin->nama }}</b></li>
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
                                                $perjadin->pokRelationship->kd_program . "." .
                                                $perjadin->pokRelationship->kd_kegiatan . "." .
                                                $perjadin->pokRelationship->kd_kro . "." .
                                                $perjadin->pokRelationship->kd_ro . "." .
                                                $perjadin->pokRelationship->kd_komponen . "." .
                                                $perjadin->pokRelationship->kd_subkomponen . "." .
                                                $perjadin->pokRelationship->kd_akun . "." .
                                                $perjadin->pokRelationship->kd_detail
                                            }}
                                        </span>
                                    </li>
                                    <li>
                                        Deskripsi Anggaran : <b>{{ $perjadin->pokRelationship->deskripsi }}</b>
                                    </li>
                                    <li>
                                        Pada Kegiatan : <b>{{ \App\Models\Pok::where('pakai', true)->where('kd_kegiatan', $perjadin->pokRelationship->kd_kegiatan)->where('kd_kro', '000')->first('deskripsi')->deskripsi }}</b>
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
                                        Anggaran yang akan digunakan sebesar <b>Rp. {{ number_format($perjadin->total, 0, ',', '.') }},-</b> dari sisa anggaran sebesar <b>Rp. {{ number_format($availableBudget, 0, ',', '.') }},-</b>
                                    </li>
                                    <li>
                                        Volume kegiatan yang akan digunakan sebesar <b>{{ $perjadin->volume . ' ' . $satuan }}</b> dari sisa volume kegiatan sebesar <b>{{ $availableVolume . ' ' . $satuan }}</b>
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

                                            @foreach ($perjadin->detailPerjalananDinasRelationship as $item)
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

                            {{-- Keterangan Tambahan --}}
                            @if(!empty($lembur->catatan))
                                <hr>
                                <div class="form-group">
                                    <p class="h6 font-weight-bold">
                                        <i class="fas fa-info-circle"></i>
                                        <span class="ml-1">Informasi Tambahan</span>
                                    </p>
                                    <div class="ml-4">{!! $perjadin->catatan !!}</div>
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
                            <span style="font-size: 1.5rem">Keterangan Pemeriksaan</span>
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
                                        'data' => $perjadin->pemeriksaanRelationship->approve_kf,
                                        'name' => 'Koordinator Fungsi',
                                        'date' => $perjadin->pemeriksaanRelationship->tanggal_approve_kf
                                    ])

                                    <div class="mt-1"><br></div>

                                    @include('components.state.approval-on-detail', [
                                        'data' => $perjadin->pemeriksaanRelationship->approve_ppk,
                                        'name' => 'Pejabat Pembuat Komitmen',
                                        'date' => $perjadin->pemeriksaanRelationship->tanggal_approve_ppk
                                    ])

                                    <div class="mt-1"><br></div>

                                    @include('components.state.approval-on-detail', [
                                        'data' => $perjadin->pemeriksaanRelationship->approve_kepala,
                                        'name' => 'Kepala BPS Provinsi Sulawesi Barat',
                                        'date' => $perjadin->pemeriksaanRelationship->tanggal_approve_kepala
                                    ])
                                </div>
                            </div>
                            <hr>

                            {{-- Hasil Pemeriksaan --}}
                            <div class="form-group">
                                <p class="h6 font-weight-bold">
                                    <i class="fas fa-comment"></i>
                                    <span class="ml-1">Catatan Pemeriksaan</span>
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
