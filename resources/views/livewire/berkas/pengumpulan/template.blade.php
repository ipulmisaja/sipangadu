{{-- Nama Kegiatan --}}
<td>
    <div class="mt-2">
        <small class="text-muted font-weight-bold">
            {{
                '054.01.' .
                $activity->pokRelationship->kd_program . '.' .
                $activity->pokRelationship->kd_kegiatan . '.' .
                $activity->pokRelationship->kd_kro . '.' .
                $activity->pokRelationship->kd_ro . '.' .
                $activity->pokRelationship->kd_komponen . '.' .
                $activity->pokRelationship->kd_subkomponen . '.' .
                $activity->pokRelationship->kd_akun
            }}
            ({{ $activity->pokRelationship->deskripsi }})
        </small>
    </div>
    <div class="my-2">
        <i class="fas fa-file-alt"></i>
        <span class="ml-1">
            {{ $activity->nama }}
        </span>
    </div>
</td>

{{-- Status Verifikasi Berkas --}}
<td>
    <label class="mt-4">
        @include('components.state.verifikasi', [
            'verifikasi' => $model->verifikasi
        ])
    </label>
</td>

{{-- Catatan Verifikasi --}}
<td>
    @if (!is_null($model->catatan_verifikator))
        <p>{{ strip_tags($model->catatan_verifikator) }}</p>
    @else
        <span>Tidak Ada Catatan</span>
    @endif
</td>

{{-- Status Unggah Berkas --}}
<td>
    @include('components.state.berkas', [
        'file' => $model->file
    ])
</td>

{{-- Aksi --}}
<td>
    <a
        href="{{ url(env('APP_URL') . 'berkas/unggah-berkas/'. $model->id) }}"
        class="btn btn-icon btn-info"
        data-toggle="tooltip"
        data-placement="bottom"
        title=""
        data-original-title="Unggah Berkas">
        <i class="fas fa-upload"></i>
    </a>
</td>
