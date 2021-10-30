@section('title', $activityGroup[0]->proposal_id)

<div class="main-content">
    {{-- Section --}}
    <section class="section" style="z-index:0">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">Tindak Lanjut Pengajuan Kegiatan</p>
        </div>

        {{-- Body --}}
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">
                        <div class="card-body">
                            @php
                                $relationship = getModelRelationship($activityGroup[0]->proposal_id)['relationship'];
                            @endphp

                            {{-- Detail --}}
                            @switch(getModelRelationship($activityGroup[0]->proposal_id)['abbreviation'])
                                @case('FB')
                                    @include('components.item.detail', [
                                        'detail' => $activityGroup[0]->$relationship,
                                        'availableBudget' => $activityGroup[1],
                                        'availableVolume' => $activityGroup[2],
                                        'satuan' => $activityGroup[3],
                                        'type'   => 'fullboard'
                                    ])
                                    @break
                                @case('LB')
                                    @include('components.item.detail', [
                                        'detail' => $activityGroup[0]->$relationship,
                                        'type'   => 'overtime'
                                    ])
                                    @break
                                @case('PD')
                                    @include('components.item.detail', [
                                        'detail' => $activityGroup[0]->$relationship,
                                        'availableBudget' => $activityGroup[1],
                                        'availableVolume' => $activityGroup[2],
                                        'satuan' => $activityGroup[3],
                                        'type'   => 'trip'
                                    ])
                                    @break
                            @endswitch

                            <form wire:submit.prevent="save('{{ $activityGroup[0]->proposal_id }}')">
                                @if(auth()->user()->hasRole('subkoordinator'))
                                    @switch(auth()->user()->unitRelationship->slug)
                                        @case('kepeghum')
                                            <hr>
                                            <div class="form-group">
                                                <p class="h6 font-weight-bold">
                                                    <i class="fas fa-clipboard-list"></i>
                                                    <span class="ml-1">Tindak Lanjut Oleh Fungsi Kepegawaian dan Hukum</span>
                                                </p>
                                                <span class="ml-4">
                                                    Dokumen yang perlu dilengkapi yaitu
                                                    <ul class="mt-1">
                                                        <li>SK Pelaksanaan Kegiatan</li>
                                                        <li>Daftar Nama Panitia</li>
                                                    </ul>
                                                    <div class="row">
                                                        <div class="col-11">
                                                            <div class="ml-4">
                                                                <label class="font-weight-bold">Unggah Berkas (.pdf)</label>
                                                                <input wire:model.lazy="file" type="file" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-1">
                                                            <label class="font-weight-bold text-white">localhost</label>
                                                            <button class="btn btn-icon icon-left btn-primary">
                                                                <i class="fas fa-save"></i>
                                                                <span class="ml-1">Simpan</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>

                                            @break
                                        @case('keuangan')
                                            <div class="form-group">
                                                @switch($activity->$relationship->getTable())
                                                    {{-- @case('fullboard')
                                                        <p class="h6 font-weight-bold">
                                                            <i class="fas fa-clipboard-list"></i>
                                                            <span class="ml-1">Tindak Lanjut Oleh Fungsi Keuangan</span>
                                                        </p>
                                                        <span class="ml-4">
                                                            Dokumen yang perlu dilengkapi yaitu
                                                            <ul class="mt-1">
                                                                <li>SPJ Kegiatan</li>
                                                            </ul>
                                                            <div class="ml-4">
                                                                <label class="font-weight-bold">Unggah Berkas (.pdf)</label>
                                                                <input wire:model="followup_file" type="file" class="form-control">
                                                            </div>
                                                        </span>
                                                        @break
                                                    @case('overtime')
                                                        <p class="h6 font-weight-bold">
                                                            <i class="fas fa-clipboard-list"></i>
                                                            <span class="ml-1">Tindak Lanjut Oleh Fungsi Keuangan</span>
                                                        </p>
                                                        <span class="ml-4">
                                                            Dokumen yang perlu dilengkapi yaitu
                                                            <ul class="mt-1">
                                                                <li>SPJ Lembur</li>
                                                            </ul>
                                                            <div class="ml-4">
                                                                <label class="font-weight-bold">Unggah Berkas (.pdf)</label>
                                                                <input wire:model="followup_file" type="file" class="form-control">
                                                            </div>
                                                        </span>
                                                        @break --}}
                                                    @case('perjalanan_dinas')
                                                        <hr>
                                                        <p class="h6 font-weight-bold">
                                                            <i class="fas fa-clipboard-list"></i>
                                                            <span class="ml-1">Tindak Lanjut Oleh Fungsi Keuangan</span>
                                                        </p>
                                                        <span class="ml-3">
                                                            <button
                                                                class="mt-2 btn btn-icon icon-left btn-primary"
                                                                onclick="window.location.href='{{ \Storage::url('files/document/surat_tugas.xlsx') }}'">
                                                                <i class="fas fa-download"></i>
                                                                <span class="ml-1">Unduh Surat Tugas</span>
                                                            </button>
                                                        </span>
                                                        @break
                                                @endswitch
                                            </div>
                                            @break
                                        @case('umum')
                                            @break
                                        @case('pengadaan-barjas')
                                            <div class="form-group">
                                                <p class="h6 font-weight-bold">
                                                    <i class="fas fa-clipboard-list"></i>
                                                    <span class="ml-1">Tindak Lanjut Oleh Seksi Pengadaan Barang Jasa</span>
                                                </p>
                                                <span class="ml-4">
                                                    Dokumen yang perlu dilengkapi yaitu
                                                    <ul class="mt-1">
                                                        <li>Dokumen Pengadaan Barang dan Jasa</li>
                                                    </ul>
                                                    <div class="ml-4">
                                                        <label class="font-weight-bold">Unggah Berkas (.pdf)</label>
                                                        <input wire:model.lazy="file" type="file" class="form-control">
                                                    </div>
                                                </span>
                                            </div>
                                            @break
                                        @default
                                    @endswitch
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
