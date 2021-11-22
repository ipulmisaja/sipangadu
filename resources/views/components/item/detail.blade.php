{{-- Kode & Deskripsi Anggaran --}}
<div class="form-group">
    <p class="h6 font-weight-bold">
        <i class="fas fa-coins"></i>
        <span class="ml-1">Kode & Deskripsi Anggaran</span>
    </p>
    @switch($type)
        @case('msm')
            @php
                $model  = \App\Models\Pok::query()
                            -> whereIn('id', $detail->pok_id)
                            -> get();

                $header = \App\Models\Pok::query()
                            -> where('kd_kegiatan', $model[0]->kd_kegiatan)
                            -> where('kd_kro', $model[0]->kd_kro)
                            -> where('kd_ro', $model[0]->kd_ro)
                            -> where('kd_komponen', '000')
                            -> first();
            @endphp

            <p class="ml-4">
                <span class="font-weight-bold text-primary">
                    {{
                        $header->kd_kegiatan . '.' .
                        $header->kd_kro . '.' .
                        $header->kd_ro
                    }}
                </span><br>
                <span class="font-weight-bold">{{ $header->deskripsi }}</span>
                <ol>
                    @foreach ($model as $item)
                        <li>
                            <label class="font-weight-bold text-danger">
                                Komponen ({{ $item->kd_komponen }})
                            </label>
                            <p class="h6">
                                {{ ucwords(strtolower($item->deskripsi)) }}
                            </p>
                        </li>
                    @endforeach
                </ol>
            </p>
            @break
        @default
            <ul class="ml-4">
                <li>
                    Kode Anggaran :
                    <span class="text-primary font-weight-bold">
                        {{
                            '054.01.' .
                            $detail->pokRelationship->kd_program . "." .
                            $detail->pokRelationship->kd_kegiatan . "." .
                            $detail->pokRelationship->kd_kro . "." .
                            $detail->pokRelationship->kd_ro . "." .
                            $detail->pokRelationship->kd_komponen . "." .
                            $detail->pokRelationship->kd_subkomponen . "." .
                            $detail->pokRelationship->kd_akun . "." .
                            $detail->pokRelationship->kd_detail
                        }}
                    </span>
                </li>
                <li>
                    Deskripsi Anggaran : <b>{{ $detail->pokRelationship->deskripsi }}</b>
                    pada kegiatan <b>{{ \App\Models\Pok::where('pakai', true)->where('kd_kegiatan', $detail->pokRelationship->kd_kegiatan)->where('kd_kro', '000')->first('deskripsi')->deskripsi }}</b>
                </li>
            </ul>
    @endswitch
</div>
<hr>

{{-- Dasar Perubahan Anggaran --}}
@if ($type === 'msm')
    <div class="form-group">
        <p class="h6 font-weight-bold">
            <i class="fas fa-sticky-note"></i>
            <span class="ml-1">Dasar Perubahan Anggaran</span>
        </p>
        <div class="ml-4 mt-3">
            {!! $detail->catatan !!}
        </div>
    </div>
    <hr>
@endif

{{-- Tanggal Pengajuan --}}
<div class="form-group">
    <p class="h6 font-weight-bold">
        <i class="fas fa-calendar"></i>
        <span class="ml-2">Informasi Tanggal</span>
    </p>
    <ul class="ml-4">
        @if ($type === 'msm')
            <li>
                Pengajuan perubahan anggaran ini diajukan pada tanggal <b>{{ DateFormat::convertDateTime($detail->tanggal_pengajuan) }}</b>
            </li>
        @elseif ($type === 'fullboard')
            <li>
                Kegiatan ini akan dilaksanakan pada tanggal <b>
                    {{ DateFormat::convertDateTime($detail->tanggal_mulai) . " - " . DateFormat::convertDateTime($detail->tanggal_berakhir) }}</b>
            </li>
        @else
            <li>
                Belanja Kegiatan ini diajukan pada tanggal <b>{{ DateFormat::convertDateTime($detail->pemeriksaanRelationship->tanggal_pengajuan) }}</b>
            </li>
        @endif

    </ul>
</div>
<hr>


{{-- Unduh Berkas --}}
<div class="form-group">
    <p class="h6 font-weight-bold">
        <i class="fas fa-search"></i>
        <span class="ml-2">
            @if ($type === 'fullboard')
                Preview Berkas
            @else
                Unduh Berkas
            @endif
        </span>
    </p>
    @if ($type === 'msm')
        <a
            href="{{ google_view_file($detail->file) }}"
            target="_blank"
            class="ml-4 mt-2 btn btn-icon icon-left btn-info">
            <i class="fa fa-download"></i>
            <span class="ml-1">Unduh</span>
        </a>
    @elseif ($type === 'fullboard')
        <iframe class="ml-4 mt-2" src="{{ google_view_file($detail->file) }}" width="98%" height="600px"></iframe>
    @elseif ($type === 'overtime' || $type === 'trip')
        <a
            href="{{ route('pdf.generate', ['id' => $detail->reference_id]) }}"
            class="ml-4 mt-2 btn btn-icon icon-left btn-info">
            <i class="fa fa-download"></i>
            <span class="ml-1">Unduh</span>
        </a>
    @endif
</div>
<hr>

{{-- Keterangan Approval --}}
<div class="form-group">
    <p class="h6 font-weight-bold">
        <i class="fas fa-thumbs-up"></i>
        <span class="ml-1">Keterangan Pemeriksaan</span>
    </p>
    <div class="ml-4 mt-4">
        @if ($type === 'msm')
            @include('components.state.approval-on-detail', [
                'data' => $detail->approve_kf,
                'name' => 'Koordinator Fungsi',
                'date' => $detail->tanggal_approve_kf
            ])

            <div class="mt-1"><br></div>

            @include('components.state.approval-on-detail', [
                'data' => $detail->approve_ppk,
                'name' => 'Pejabat Pembuat Komitmen',
                'date' => $detail->tanggal_approve_ppk
            ])
        @else
            @include('components.state.approval-on-detail', [
                'data' => $detail->pemeriksaanRelationship->approve_kf,
                'name' => 'Koordinator Fungsi',
                'date' => $detail->pemeriksaanRelationship->tanggal_approve_kf
            ])

            <div class="mt-1"><br></div>

            @include('components.state.approval-on-detail', [
                'data' => $detail->pemeriksaanRelationship->approve_ppk,
                'name' => 'Pejabat Pembuat Komitmen',
                'date' => $detail->pemeriksaanRelationship->tanggal_approve_ppk
            ])

            @if($type === 'overtime' || $type === 'trip')
                <div class="mt-1"><br></div>
                @include('components.state.approval-on-detail', [
                    'data' => $detail->pemeriksaanRelationship->approve_kepala,
                    'name' => 'Kepala BPS Provinsi Sulawesi Barat',
                    'date' => $detail->pemeriksaanRelationship->tanggal_approve_kepala
                ])
            @endif
        @endif
    </div>
</div>
