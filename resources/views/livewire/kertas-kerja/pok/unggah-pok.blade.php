@section('title', 'Unggah POK')

<div class="main-content">
    <section class="section" style="z-index:0">
        <div class="section-header">
            <p class="h3 font-weight-bold">Unggah Petunjuk Operasional Kegiatan</p>
        </div>
        <div class="section-body">
            <form wire:submit.prevent="save">
                <div class="card border rounded">
                    <div class="card-body">
                        {{-- Tahun Anggaran --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">Tahun Anggaran</div>
                                <div class="col-9">
                                    <input wire:model.lazy="tahun" type="number" class="form-control" min="2021">
                                    @error('tahun')
                                        <div class="mt-2">
                                            <span class="text-danger">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>

                        {{-- Pok Excel --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">Unggah POK (*.xls)</div>
                                <div class="col-9">
                                    <input id="pok" wire:model.lazy="pok" type="file" ref="input" class="form-control">
                                    <div wire:loading wire:target="pok">Uploading...</div>
                                    @error('pok')
                                        <div class="mt-2">
                                            <span class="text-danger">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-secondary">
                        <button class="btn btn-icon icon-left btn-primary float-right">
                            <i class="fas fa-save"></i>
                            <span class="ml-1">Simpan</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
