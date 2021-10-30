{{-- Nama Kegiatan --}}
<td>
    <div class="mt-2 text-muted">
        <i class="fas fa-calendar"></i>
        <span class="ml-1">{{ DateFormat::convertDateTime($kegiatan->pemeriksaanRelationship->tanggal_pengajuan) }}</span>
    </div>
    <div class="my-2">
        {{ $kegiatan->nama }}
    </div>
</td>

{{-- Kode Anggaran --}}
<td>
    <div class="mt-2">
        <small class="text-muted font-weight-bold">
            {{
                '054.01.' .
                $kegiatan->pokRelationship->kd_program . '.' .
                $kegiatan->pokRelationship->kd_kegiatan . '.' .
                $kegiatan->pokRelationship->kd_kro . '.' .
                $kegiatan->pokRelationship->kd_ro . '.' .
                $kegiatan->pokRelationship->kd_komponen . '.' .
                $kegiatan->pokRelationship->kd_subkomponen . '.' .
                $kegiatan->pokRelationship->kd_akun
            }}
        </small><br>
        <span class="font-weight-bold text-primary">
            {{ $kegiatan->pokRelationship->deskripsi }}
        </span>
    </div>
</td>

{{-- Status Verifikasi Berkas --}}
<td>
    @include('components.state.verifikasi', [
        'verifikasi' => $berkas->verifikasi
    ])
</td>

{{-- Pengumpulan Berkas Fisik --}}
<td>
    @include('components.state.file', [
        'verifikasi' => $berkas->has_collect
    ])
</td>

{{-- Aksi / Catatan Verifikator --}}
<td>
    @if ($role === 'ppk')
        {!! $berkas->catatan_verifikator !!}
    @else
        @if ($berkas->has_collect)
            {!! $berkas->catatan_verifikator !!}
        @else
            <a
            href="{{ url(env('APP_URL') . 'berkas/verifikasi-berkas/'. $berkas->id) }}"
            class="btn btn-icon btn-primary"
            data-toggle="tooltip"
            data-placement="bottom"
            title=""
            data-original-title="Verifikasi Berkas">
                <i class="fas fa-edit"></i>
            </a>
        @endif
    @endif
</td>
