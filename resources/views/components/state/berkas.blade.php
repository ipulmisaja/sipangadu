@if (!is_null($file))
    <a
        href="{{ google_view_file($file) }}"
        target="_blank"
        class="btn btn-icon icon-left btn-primary">
        <i class="fas fa-download"></i>
        <span class="ml-1">Unduh</span>
    </a>
@else
    <span class="badge badge-danger">Belum Unggah</label>
@endif
