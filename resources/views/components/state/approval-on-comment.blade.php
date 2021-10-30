@switch($data)
    @case(1)
        <div class="badge badge-primary icon-left">
            <i class="fas fa-check-circle"></i>
            <span class="ml-1">Diterima</span>
        </div>
        @break
    @case(2)
        <div class="badge badge-danger icon-left">
            <i class="fas fa-times-circle"></i>
            <span class="ml-1">Ditolak</span>
        </div>
        @break
    @default
        <div class="badge badge-info icon-left">
            <i class="fas fa-spinner"></i>
            <span class="ml-1">Belum Diapprove</span>
        </div>
@endswitch
