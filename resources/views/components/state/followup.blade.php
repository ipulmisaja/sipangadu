@switch($model->followup)
    @case (true)
        <div class="badge badge-primary">
            <i class="fas fa-check"></i>
            <span class="ml-1">Selesai</span>
        </div>
        @break
    @case (false)
        <div class="badge badge-warning">
            <i class="fas fa-spinner"></i>
            <span class="ml-1">Belum<span>
        </div>
@endswitch
