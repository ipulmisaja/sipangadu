@section('title', 'Pengaturan User')

<div class="main-content">
    {{-- Notification --}}
    @include('components.notification.toast')

    {{-- Section --}}
    <section class="section" class="z-index:0">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">Pengaturan User</p>
        </div>

        {{-- Body --}}
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">
                        {{-- Card Header --}}
                        <div class="card-header">
                            <h4>
                                <a wire:click="$set('modal', 'create')" class="btn btn-icon icon-left btn-primary text-white">
                                    <i class="fa fa-plus"></i>
                                    <span class="ml-1">Tambah User Baru</span>
                                </a>
                            </h4>
                            <div class="card-header-form">
                                <form action="">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body">
                            @if ($daftarUser->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <tbody>
                                            {{-- Columns --}}
                                            <tr>
                                                <th>
                                                    <div class="custom-checkbox custom-control text-center">
                                                        <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                                        <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                                    </div>
                                                </th>
                                                <th>Nama Pegawai</th>
                                                <th>Pangkat/Golongan</th>
                                                <th>Hak Akses</th>
                                                <th>Unit Kerja</th>
                                                <th>Aksi</th>
                                            </tr>

                                            {{-- Content --}}
                                            @foreach ($daftarUser->paginate(20) as $user)
                                                <tr>
                                                    <td class="p-0 text-center">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-1">
                                                            <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if ($user->foto)
                                                            <img src="{{ $user->foto }}" class="rounded-circle">
                                                        @endif
                                                        {{ $user->nama }}
                                                    </td>
                                                    <td>
                                                        {{ $user->pangkatGolonganRelationship->nama ?? '-' }}
                                                    </td>
                                                    <td>
                                                        @foreach ($user->roles as $role)
                                                            @include('livewire.setting.user.template.role-color', [
                                                                'data' => $role->name
                                                            ])
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        {{ $user->unitRelationship->nama ?? '-' }}
                                                    </td>
                                                    <td>
                                                        <button
                                                            wire:click="edit('{{ $user->slug }}')"
                                                            class="btn btn-icon btn-primary"
                                                            data-toggle="tooltip"
                                                            data-placement="bottom"
                                                            title=""
                                                            data-original-title="Edit Pegawai">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{ $daftarUser->paginate(20)->links('vendor.pagination.sipangadu') }}
                            @else
                                @include('components.notification.not-found', [
                                    'data_height' => 400,
                                    'description' => "Maaf, kami tidak dapat menemukan data apapun, " .
                                                     "untuk menghilangkan pesan ini, tambah setidaknya 1 user."
                                ])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Create Edit User Modal --}}
    @switch($modal)
        @case('create')
            @livewire('setting.user.create-edit-user', ['stage' => 'create'])
            @break
        @case('edit')
            @livewire('setting.user.create-edit-user', ['stage' => 'edit'])
            @break
        @default
    @endswitch
</div>
