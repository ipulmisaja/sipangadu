<div>
    @switch($stage)
        @case('create')
            @include('livewire.setting.webhook.webhook-template', [
                'method' => 'create',
                'title'  => 'Tambah Webhook'
            ])
            @break
        @case('edit')
            @include('livewire.setting.webhook.webhook-template', [
                'method' => 'edit',
                'title'  => 'Edit Webhook'
            ])
            @break
    @endswitch
</div>
