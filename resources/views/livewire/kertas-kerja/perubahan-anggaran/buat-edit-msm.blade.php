@section('title', 'Pengajuan MSM')

<div class="main-content">
    {{-- Section --}}
    <section class="section" style="z-index:0">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">{{ $title }}</p>
        </div>

        {{-- Body --}}
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <form wire:submit.prevent="{{ $method }}">
                        <div class="card border rounded">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-3">
                                            Kode Kegiatan
                                        </div>
                                        <div class="col-9">
                                            <select wire:model="activity" class="form-control">
                                                <option value="null">- Pilih Kode Kegiatan -</option>
                                                @foreach ($activityList as $activityItem)
                                                    <option value="{{ $activityItem->kd_kegiatan }}">
                                                        {{
                                                            "054.01." .
                                                            $activityItem->kd_program . "." .
                                                            $activityItem->kd_kegiatan . " - " .
                                                            $activityItem->deskripsi
                                                        }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('acativity')
                                                <div class="mt-3">
                                                    <small class="text-danger">{{ $message }}</small>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                {{-- Kode Rincian Output --}}
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-3">
                                            Kode Rincian Output
                                        </div>
                                        <div class="col-9">
                                            <select wire:model="output" class="form-control">
                                                <option value="null">- Pilih Kode Rincian Output -</option>
                                                @if (isset($outputList))
                                                    @foreach ($outputList as $outputItem)
                                                        <option value="{{ $outputItem->kd_ro }}">
                                                            {{
                                                                $outputItem->kd_kegiatan . '.' .
                                                                $outputItem->kd_kro . '.' .
                                                                $outputItem->kd_ro . ' - ' .
                                                                $outputItem->deskripsi
                                                            }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('output')
                                                <div class="mt-3">
                                                    <small class="text-danger">{{ $message }}</small>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                {{-- Kode Komponen --}}
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-3">
                                            Kode Komponen
                                        </div>
                                        <div class="col-9">
                                            <select wire:model="component" class="form-control">
                                                <option value="null">- Pilih Komponen Kegiatan -</option>
                                                @if (isset($componentList))
                                                    @foreach ($componentList as $componentItem)
                                                        <option value="{{ $componentItem->id . '.' . $componentItem->kd_komponen . ' - ' . $componentItem->deskripsi }}">
                                                            {{ $componentItem->kd_komponen . ' - ' . $componentItem->deskripsi }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if(count($componentArray) > 0)
                                                @foreach ($componentArray as $componentItem)
                                                    <span class="mt-2 badge badge-info">
                                                        <span class="border-right border-white pr-1 mr-1">
                                                            {{ $componentItem }}
                                                        </span>
                                                        <span wire:click="deleteComponent('{{ $componentItem }}')" role="button" tabindex="0">
                                                            &times;
                                                        </span>
                                                    </span>
                                                @endforeach
                                            @endif
                                            @error('component')
                                                <div class="mt-3">
                                                    <small class="text-danger">{{ $message }}</small>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                {{-- Dasar Revisi --}}
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-3">
                                            Dasar Pertimbangan Revisi
                                        </div>
                                        <div class="col-9">
                                            <div wire:ignore x-data @trix-blur="$dispatch('change', $event.target.value)">
                                                <trix-editor wire:model.lazy="description" class="form-textarea"></trix-editor>
                                            </div>
                                            @error('description')
                                                <div class="mt-3">
                                                    <small class="text-danger">{{ $message }}</small>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                {{-- File MSM --}}
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-3">
                                            <span>Scan Nota Dinas, Rekapan MSM, excel MSM<span><br>
                                            <span class="font-weight-bold text-muted">(zip, ukuran file max: 2 MB)</span>
                                        </div>
                                        <div class="col-9">
                                            <input wire:model.lazy="file" type="file" ref="input" class="form-control">
                                            @error('file')
                                                <div class="mt-3">
                                                    <small class="text-danger">{{ $message }}</small>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- footer button --}}
                            <div class="card-footer bg-secondary">
                                <button type="submit" class="btn btn-icon icon-left btn-primary float-right">
                                    <i class="far fa-save"></i>
                                    SIMPAN
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
