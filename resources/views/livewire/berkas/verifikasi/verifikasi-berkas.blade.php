@section('title', 'Verifikasi Berkas')

@php
    $relationship = getModelRelationship($verifikasi->reference_id)['relationship'];
@endphp

<div class="main-content">
    <section class="section" style="z-index:0">
        <div class="section-header">
            <p class="h3">Verifikasi Berkas</p>
        </div>
        <div class="section-body">
            {{-- Informasi Utama --}}
            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">
                        <div class="card-header bg-light">
                            <span style="font-size: 1.5rem">Informasi Utama</span>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <p class="h6 font-weight-bold">
                                    <i class="fas fa-file-alt"></i>
                                    <span class="ml-1">Nama Kegiatan</span>
                                </p>
                                <p class="ml-4">
                                    {{ $verifikasi->$relationship->nama }}
                                </p>
                            </div>
                            <hr>

                            <div class="form-group">
                                <p class="h6 font-weight-bold">
                                    <i class="fas fa-coins"></i>
                                    <span class="ml-1">Pagu Kegiatan</span>
                                </p>
                                <p class="ml-4">
                                    <span class="text-primary font-weight-bold">
                                        {{
                                            '054.01.' .
                                            $verifikasi->$relationship->pokRelationship->kd_program . "." .
                                            $verifikasi->$relationship->pokRelationship->kd_kegiatan . "." .
                                            $verifikasi->$relationship->pokRelationship->kd_kro . "." .
                                            $verifikasi->$relationship->pokRelationship->kd_ro . "." .
                                            $verifikasi->$relationship->pokRelationship->kd_komponen . "." .
                                            $verifikasi->$relationship->pokRelationship->kd_subkomponen . "." .
                                            $verifikasi->$relationship->pokRelationship->kd_akun
                                        }}11
                                    </span><br>
                                    <span>{{ $verifikasi->$relationship->pokRelationship->deskripsi }}</span>
                                </p>
                            </div>
                            <hr>

                            <div class="form-group">
                                <p class="h6 font-weight-bold">
                                    <i class="fas fa-user"></i>
                                    <span class="ml-1">Pengunggah / Pemilik Berkas</span>
                                </p>
                                <p class="ml-4">
                                    {{ $verifikasi->userRelationship->nama }}
                                </p>
                            </div>
                            <hr>

                            @if (explode('-', $verifikasi->reference_id)[0] === 'PD')
                                <div class="form-group">
                                    <p class="h6 font-weight-bold">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span class="ml-1">Tujuan dan Waktu Perjalanan Dinas</span>
                                    </p>
                                    <p class="ml-4">
                                        <ul>
                                            <li>Tempat Tujuan Perjalanan Dinas <b class="text-primary">{{ $verifikasi->perjadinRelationship->detailPerjalananDinasRelationship[0]->tujuan }}</b></li>
                                            <li>Waktu Perjalanan Dinas <b class="text-primary">
                                                {{
                                                    DateFormat::convertDateTime($verifikasi->perjadinRelationship->detailPerjalananDinasRelationship[0]->tanggal_berangkat) . ' - ' .
                                                    DateFormat::convertDateTime($verifikasi->perjadinRelationship->detailPerjalananDinasRelationship[0]->tanggal_kembali)
                                                }}</b>
                                            </li>
                                        </ul>
                                    </p>
                                </div>
                                <hr>
                            @endif

                            <div class="form-group">
                                <p class="h6 font-weight-bold">
                                    <i class="fas fa-download"></i>
                                    <span class="ml-1">Preview Berkas</span>
                                </p>
                                <iframe
                                    class="ml-4 mt-2"
                                    src="{{ google_view_file($verifikasi->file)}}"
                                    width="98%" height="600px">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Keterangan Verifikasi --}}
            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">
                        <div class="card-header bg-light">
                            <span style="font-size: 1.5rem">Keterangan Verifikasi</span>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <p class="h6 font-weight-bold">
                                    <i class="fas fa-edit"></i>
                                    <span class="ml-1">Verifikasi Berkas Kegiatan</span>
                                </p>
                                <div class="ml-4 mt-4">
                                    <form wire:submit.prevent="save">
                                        <div class="card border rounded">
                                            <div class="card-body">
                                                {{-- Status Verifikasi --}}
                                                <div class="row">
                                                    <div class="col-3">Status Verifikasi</div>
                                                    <div class="col-9">
                                                        <select wire:model="statusVerifikasi" class="form-control">
                                                            <option value="null">- Status Verifikasi -</option>
                                                            <option value="1">Diterima</option>
                                                            <option value="2">Ditolak</option>
                                                        </select>
                                                        @error('statusVerifikasi')
                                                            <div class="mt-3">
                                                                <span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <hr class="my-4">

                                                {{-- Catatan Verifikasi --}}
                                                <div class="row">
                                                    <div class="col-3">Catatan Verifikasi</div>
                                                    <div class="col-9">
                                                        <div wire:ignore x-data @trix-blur="$dispatch('change', $event.target.value)">
                                                            <trix-editor wire:model.lazy="catatanVerifikasi" class="form-textarea"></trix-editor>
                                                        </div>
                                                        @error('catatanVerifikasi')
                                                            <div class="mt-3">
                                                                <span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <hr class="my-4">

                                                {{-- Pengumpulan Berkas Fisik --}}
                                                <div class="row">
                                                    <div class="col-3">Pengumpulan Berkas Fisik</div>
                                                    <div class="col-9">
                                                        <div class="custom-control custom-checkbox">
                                                            <input wire:model="hasCollect" type="checkbox" class="custom-control-input" id="customCheck1">
                                                            <label class="custom-control-label" for="customCheck1">{!! $hasCollect ? "<span class='text-primary'>Sudah Dikumpulkan</span>" : 'Belum Dikumpulkan' !!}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer bg-secondary">
                                                <button type="submit" class="btn btn-icon icon-left btn-primary float-right">
                                                    <i class="fas fa-save"></i>
                                                    <span class="ml-1">Simpan</span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
