@switch($data)
    @case('admin')
        <span class="badge badge-primary mr-1">{{ $data }}</span>
        @break
    @case('kpa')
        <span class="badge badge-info mr-1">{{ $data }}</span>
        @break
    @case('ppk')
        <span class="badge badge-warning mr-1">{{ $data }}</span>
        @break
    @case('koordinator')
    <span class="badge badge-success mr-1">{{ $data }}</span>
        @break
    @case('subkoordinator')
        <span class="badge badge-danger mr-1">{{ $data }}</span>
        @break
    @case('staf')
        <span class="badge badge-secondary mr-1">{{ $data }}</span>
        @break
    @case('binagram')
        <span class="badge badge-light mr-1">{{ $data }}</span>
        @break
    @case('sekretaris')
        <span class="badge badge-dark mr-1">{{ $data }}</span>
        @break
    @default
@endswitch
