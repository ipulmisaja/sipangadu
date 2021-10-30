<div>
    @switch($stage)
        @case('create')
            @include('livewire.setting.role.template.create-edit-template', [
                'method' => 'save',
                'title'  => 'Tambah Hak Akses Baru'
            ])
            @break
        @case('edit')
            @include('livewire.setting.role.template.create-edit-template', [
                'method' => 'update',
                'title'  => 'Edit Hak Akses'
            ])
            @break
        @default
    @endswitch
</div>
