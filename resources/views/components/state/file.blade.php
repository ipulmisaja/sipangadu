@switch($verifikasi)
    @case(true)
        <span class="badge badge-primary">
            <i class="fas fa-check"></i>
            <span class="ml-1">Berkas Sudah Dikumpulkan</span>
        </span>
        @break
    @case(false)
        <span class="badge badge-danger">
            <i class="fas fa-times"></i>
            <span class="ml-1">Berkas Belum Dikumpulkan</span>
        </span>
        @break
@endswitch
