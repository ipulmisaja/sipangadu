@switch($verifikasi)
    @case(1)
        <span class="badge badge-primary">
            <i class="fas fa-check"></i>
            <span class="ml-1">Diterima</span>
        </span>
        @break
    @case(2)
        <span class="badge badge-danger">
            <i class="fas fa-times"></i>
            <span class="ml-1">Ditolak</span>
        </span>
        @break
    @default
        <span class="badge badge-info">
            <i class="fas fa-spinner"></i>
            <span class="ml-1">Belum diverifikasi</span>
        </span>
@endswitch
