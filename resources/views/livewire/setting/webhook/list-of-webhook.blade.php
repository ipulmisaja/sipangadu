@section('title', 'Pengaturan Webhook')

<div class="main-content">
    {{-- Notification --}}
    @include('components.notification.toast')

    {{-- Section --}}
    <section class="section" style="z-index:0">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">Pengaturan Webhook</p>
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
                                    <i class="fas fa-plus"></i>
                                    <span class="ml-1">Tambah Webhook Baru</span>
                                </a>
                            </h4>
                            <div class="card-header-form">
                                <form action="">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Cari...">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body">
                            @if ($listWebhook->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <tbody>
                                            {{-- Columns --}}
                                            <th>
                                                <div class="custom-checkbox custom-control text-center">
                                                    <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                                    <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th>Aplikasi</th>
                                            <th>Url</th>
                                            <th>Status</th>
                                            <th>Aksi</th>

                                            {{-- Content --}}
                                            @foreach ($listWebhook->paginate(10) as $webhook)
                                                <tr>
                                                    <td class="p-0 text-center">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-1">
                                                            <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ $webhook->aplikasi }}
                                                    </td>
                                                    <td>
                                                        {{ is_null($webhook->url) ? '-' : $webhook->url }}
                                                    </td>
                                                    <td>
                                                        <label class="custom-switch mt-2">
                                                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" wire:click="changeStatus('{{ $webhook->id }}')" @if($webhook->status == 1) checked @endif>
                                                            <span class="custom-switch-indicator"></span>
                                                            <span class="custom-switch-description">{{ $webhook->status ? 'Aktif' : 'Tidak Aktif'}}</span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <button
                                                            wire:click.prevent="edit({{ $webhook->id }})"
                                                            class="btn btn-icon btn-primary"
                                                            data-toggle="tooltip"
                                                            data-placement="bottom"
                                                            title=""
                                                            data-original-title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $listWebhook->paginate(10)->links('vendor.pagination.sipangadu') }}
                            @else
                                @include('components.notification.not-found', [
                                    'data_height' => 400,
                                    'description' => "Maaf, kami tidak dapat menemukan data apapun, " .
                                                    "untuk menghilangkan pesan ini, tambah setidaknya 1 webhook."
                                ])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Create Edit Webhook Modal --}}
    @switch($modal)
        @case('create')
            @livewire('setting.webhook.create-edit-webhook', ['stage' => 'create'])
            @break
        @case('edit')
            @livewire('setting.webhook.create-edit-webhook', ['stage' => 'edit'])
            @break
        @default
    @endswitch
</div>
