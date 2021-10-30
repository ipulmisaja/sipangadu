@section('title', 'Unggah Berkas')

<div class="main-content">
    <section class="section" style="z-index:0">
        {{-- Section Header --}}
        <div class="section-header">
            <p class="h3">Unggah Berkas</p>
        </div>

        {{-- Section Body --}}
        <div class="section-body">
            <form wire:submit.prevent="save">
                <div class="row">
                    <div class="col-12">
                        <div class="card border rounded">
                            <div class="card-body">
                                <div class="form-group">
                                    <p class="h6 font-weight-bold">
                                        <i class="fas fa-sticky-note"></i>
                                        <span class="ml-1">Nama Kegiatan</span>
                                    </p>
                                    <p class="ml-4">
                                        @switch(explode('-', $berkas->reference_id)[0])
                                            @case('PM')
                                                {{ $berkas->paketMeetingRelationship->nama }}
                                                @break
                                            @case('LB')
                                                {{ $berkas->lemburRelationship->nama }}
                                                @break
                                            @case('PD')
                                                {{ $berkas->perjadinRelationship->nama }}
                                                @break
                                        @endswitch
                                    </p>
                                </div>
                                <hr>

                                @if (explode('-', $berkas->reference_id)[0] === 'PD')
                                    <div class="form-group">
                                        <p class="h6 font-weight-bold">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span class="ml-1">Tujuan dan Waktu Perjalanan Dinas</span>
                                        </p>
                                        <p class="ml-4">
                                            <ul>
                                                <li>Tempat Tujuan Perjalanan Dinas <b class="text-primary">{{ $berkas->perjadinRelationship->detailPerjalananDinasRelationship[0]->tujuan }}</b></li>
                                                <li>Waktu Perjalanan Dinas <b class="text-primary">
                                                    {{
                                                        DateFormat::convertDateTime($berkas->perjadinRelationship->detailPerjalananDinasRelationship[0]->tanggal_berangkat) . ' - ' .
                                                        DateFormat::convertDateTime($berkas->perjadinRelationship->detailPerjalananDinasRelationship[0]->tanggal_kembali)
                                                    }}</b>
                                                </li>
                                            </ul>
                                        </p>
                                    </div>
                                    <hr>
                                @endif

                                <div class="form-group">
                                    <p class="h6 font-weight-bold">
                                        <i class="fas fa-coins"></i>
                                        <span class="ml-1">Bukti Dokumen Pencairan</span>
                                    </p>
                                    <div class="ml-4 mt-4">
                                        <div class="row">
                                            <div class="col-2 mt-2">Unggah Berkas <b>(*.pdf, *.jpg, *.png)</b></div>
                                            <div class="col-10">
                                                <input wire:model.lazy="file" type="file" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="form-group">
                                    <p class="h6 font-weight-bold">
                                        <i class="fas fa-file"></i>
                                        <span class="ml-1">Informasi Tambahan</span>
                                    </p>
                                    <div class="ml-4 mt-4">
                                        <div class="row">
                                            <div class="col-2">Catatan Berkas <sup class="badge badge-warning">opsional</sup></div>
                                            <div class="col-10">
                                                <div wire:ignore x-data @trix-blur="$dispatch('change', $event.target.value)">
                                                    <trix-editor wire:model.lazy="fileNote" class="form-textarea"></trix-editor>
                                                </div>
                                                @error('fileNote')
                                                    <div class="mt-3">
                                                        <small class="text-danger">{{ $message }}</small>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    @if ($berkas->verifikasi > 0)
                                        <hr>
                                        <div class="form-group">
                                            <p class="h6 font-weight-bold">
                                                <i class="fas fa-comment"></i>
                                                <span class="ml-1">Catatan dari Verifikator</span>
                                            </p>
                                            <p class="ml-4">
                                                <div class="media p-3 border rounded">
                                                    <img
                                                        alt="image"
                                                        class="mr-3 rounded-circle"
                                                        src="{{
                                                            is_null($berkas->verifikatorRelationship->foto)
                                                                ? asset('vendor/stisla/img/avatar/avatar-1.png')
                                                                : $payment->verifikatorRelationship->foto
                                                            }}"
                                                        width="50"
                                                        height="83%"
                                                    >
                                                    <div class="media-body">
                                                        <div class="media-right">
                                                            @include('components.state.approval-on-comment', [
                                                                'data' => $berkas->verifikasi
                                                            ])
                                                        </div>
                                                        <div class="media-title mb-1">
                                                            {{ $berkas->verifikatorRelationship->nama }}
                                                        </div>
                                                        <div class="text-time">
                                                            <span>
                                                                <i class="fas fa-user mr-1"></i>
                                                                @foreach($berkas->verifikatorRelationship->roles as $role)
                                                                    <span>{{ $role->name }},</span>
                                                                @endforeach
                                                                <span>{{ $berkas->verifikatorRelationship->unit->nama }}</span>
                                                            </span>
                                                            <span class="mx-2"> - </span>
                                                            <span>
                                                                <i class="fas fa-calendar mr-1"></i>
                                                                {{ DateFormat::convertDateTime($berkas->updated_at) }}
                                                            </span>
                                                        </div>
                                                        <div class="h6 media-description text-muted">
                                                            {!! $berkas->catatan_verifikator !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer bg-secondary">
                                <button class="btn btn-icon icon-left btn-primary float-right">
                                    <i class="fas fa-save"></i>
                                    <span class="ml-1">Simpan</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
