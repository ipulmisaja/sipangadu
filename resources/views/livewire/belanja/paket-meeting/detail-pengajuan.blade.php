@section('title', $paketMeeting->nama)

<div class="main-content">
    {{-- Section --}}
    <section class="section" style="z-index:0">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">Detail Pengajuan Paket Meeting</p>
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
                                    <li>Tanggal Pengajuan : <b>{{ DateFormat::convertDateTime($paketMeeting->tanggal_pengajuan) }}</b></li>
                                    <li>Nomor Pengajuan Kegiatan : <b>{{ $paketMeeting->nomor_pengajuan }}</b></li>
                                    <li>Nama Kegiatan : <b>{{ $paketMeeting->nama }}</b></li>
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
                                                $paketMeeting->pokRelationship->kd_program . "." .
                                                $paketMeeting->pokRelationship->kd_kegiatan . "." .
                                                $paketMeeting->pokRelationship->kd_kro . "." .
                                                $paketMeeting->pokRelationship->kd_ro . "." .
                                                $paketMeeting->pokRelationship->kd_komponen . "." .
                                                $paketMeeting->pokRelationship->kd_subkomponen . "." .
                                                $paketMeeting->pokRelationship->kd_akun . "." .
                                                $paketMeeting->pokRelationship->kd_detail
                                            }}
                                        </span>
                                    </li>
                                    <li>
                                        Deskripsi Anggaran : <b>{{ $paketMeeting->pokRelationship->deskripsi }}</b>
                                    </li>
                                    <li>Pada Kegiatan : <b>{{ \App\Models\Pok::where('pakai', true)->where('kd_kegiatan', $paketMeeting->pokRelationship->kd_kegiatan)->where('kd_kro', '000')->first('deskripsi')->deskripsi }}</b></li>
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
                                        Anggaran yang akan digunakan sebesar <b>Rp. {{ number_format($paketMeeting->total, 0, ',', '.') }},-</b> dari sisa anggaran sebesar <b>Rp. {{ number_format($availableBudget, 0, ',', '.') }},-</b>
                                    </li>
                                    <li>
                                        Volume kegiatan yang akan digunakan sebesar <b>{{ $paketMeeting->volume . ' ' . $satuan }}</b> dari sisa volume kegiatan sebesar <b>{{ $availableVolume . ' ' . $satuan }}</b>
                                    </li>
                                </ul>
                            </div>
                            <hr>

                            {{-- Unduh Berkas --}}
                            <div class="form-group">
                                <p class="h6 font-weight-bold">
                                    <i class="fas fa-search"></i>
                                    <span class="ml-2">Preview Berkas</span>
                                </p>
                                <iframe class="ml-4 mt-2" src="{{ google_view_file($paketMeeting->file) }}" width="98%" height="600px"></iframe>
                            </div>

                            {{-- Keterangan Tambahan --}}
                            @if(!empty($paketMeeting->catatan))
                                <hr>
                                <div class="form-group">
                                    <p class="h6 font-weight-bold">
                                        <i class="fas fa-info-circle"></i>
                                        <span class="ml-1">Informasi Tambahan</span>
                                    </p>
                                    <div class="ml-4">{!! $paketMeeting->catatan !!}</div>
                                </div>
                                <hr>
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
                                        'data' => $paketMeeting->pemeriksaanRelationship->approve_kf,
                                        'name' => 'Koordinator Fungsi',
                                        'date' => $paketMeeting->pemeriksaanRelationship->tanggal_approve_kf
                                    ])

                                    <div class="mt-1"><br></div>

                                    @include('components.state.approval-on-detail', [
                                        'data' => $paketMeeting->pemeriksaanRelationship->approve_ppk,
                                        'name' => 'Pejabat Pembuat Komitmen',
                                        'date' => $paketMeeting->pemeriksaanRelationship->tanggal_approve_ppk
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

                            {{-- Hasil Rekomendasi --}}
                            @if ($comments->count() === 3)
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
