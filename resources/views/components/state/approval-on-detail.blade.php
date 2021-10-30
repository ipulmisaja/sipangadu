@switch($data)
    @case (1)
        <div class="badge badge-primary">
            <i class="fas fa-check"></i>
            <span class="ml-1">
                Diterima {{ $name }} Pada Tanggal {{ DateFormat::convertDateTime($date) }}
            </span>
        </div>
        @break
    @case (2)
        <div class="badge badge-danger">
            <i class="fas fa-times"></i>
            <span class="ml-1">
                Ditolak {{ $name }} Pada Tanggal {{ DateFormat::convertDateTime($date) }}
            </span>
        </div>
        @break
    @default
        <div class="badge badge-warning">
            <i class="fas fa-spinner"></i>
            <span class="ml-1">Belum Diperiksa {{ $name }}</span>
        </div>
@endswitch
