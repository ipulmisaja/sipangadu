@section('title', 'Pengaturan Hak Akses')

<div class="main-content">
    {{-- Notification --}}
    @include('components.notification.toast')

    {{-- Section --}}
    <section class="section" style="z-index:0">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">Pengaturan Hak Akses Pengguna Aplikasi</p>
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
                                    Tambah Hak Akses
                                </a>
                            </h4>
                            <div class="card-header-form">
                                <form>
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
                        <div class="section-body">
                            @if ($list_role->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        {{-- Columns --}}
                                        <tr>
                                            <th>
                                                <div class="custom-checkbox custom-control text-center">
                                                    <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                                    <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th>Nama Hak Akses</th>
                                            <th>Deskripsi</th>
                                            <th>Warna Dasar</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>

                                        {{-- Content --}}
                                        @foreach ($list_role->paginate(10) as $role)
                                            <tr>
                                                <td class="p-0 text-center">
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-1">
                                                        <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                                    </div>
                                                </td>
                                                <td>{{ strtoupper($role->name) }}</td>
                                                <td>{{ $role->description }}</td>
                                                <td> - </td>
                                                <td>{{ DateFormat::convertDateTime($role->created_at) }}</td>
                                                <td>
                                                    <button
                                                        wire:click="edit('{{ $role->id }}')"
                                                        type="button"
                                                        class="btn btn-icon btn-primary"
                                                        data-toggle="tooltip"
                                                        data-placement="bottom"
                                                        title=""
                                                        data-original-title="Edit Hak Akses">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                {{ $list_role->paginate(10)->links('vendor.pagination.sipangadu') }}
                            @else
                                @include('components.notification.not-found', [
                                    'data_height' => 400,
                                    'description' => "Maaf, kami tidak dapat menemukan data apapun, " .
                                                    "untuk menghilangkan pesan ini, buat setidaknya 1 hak akses."
                                ])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Input Modal Dialog --}}
    @switch($modal)
        @case('create')
            @livewire('setting.role.create-edit-role', ['stage' => 'create'])
            @break
        @case('edit')
            @livewire('setting.role.create-edit-role', ['stage' => 'edit'])
            @break
        @default
    @endswitch
</div>
