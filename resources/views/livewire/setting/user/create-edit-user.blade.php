<div>
    @switch($stage)
        @case('create')
            @include('livewire.setting.user.template.create-edit-template', [
                'method' => 'save',
                'title'  => 'Tambah Pengguna Aplikasi Baru'
            ])
            @break
        @case('edit')
            @include('livewire.setting.user.template.create-edit-template', [
                'method' => 'update',
                'title'  => 'Edit Informasi Pengguna Aplikasi'
            ])
            @break
        @default
    @endswitch
</div>
