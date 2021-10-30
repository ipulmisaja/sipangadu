@switch($state)
    @case('INFO')
        <span class="badge badge-primary">Info</span>
        @break
    @case('EMERGENCY')
        <span class="badge badge-secondary">Emergency</span>
        @break
    @case('CRITICAL')
        <span class="badge badge-dark">Critical</span>
        @break
    @case('ALERT')
        <span class="badge badge-info">Alert</span>
        @break
    @case('ERROR')
        <span class="badge badge-danger">Error</span>
        @break
    @case('WARNING')
        <span class="badge badge-warning">Warning</span>
        @break
    @default
        <span class="badge badge-success">Notice</span>
@endswitch
