@section('title', 'Daftar Unggah Dokumen Pencairan')

<div class="main-content">
    {{-- Section --}}
    <section class="section" style="z-index:0">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">Kelengkapan Berkas Pencairan Anggaran</p>
        </div>

        {{-- Body --}}
        <div class="section-body">
            {{-- Notifikasi --}}
            @include('components.notification.flash')

            <div class="row">
                <div class="col-12">
                    <div class="border card rounded">
                        {{-- card header --}}
                        {{-- FIXME: error saat memilih --}}
                        {{-- <div class="card-header">
                            <h4 class="w-25">
                                <select wire:model="activityType" class="form-control">
                                    <option value>- Seluruh Kegiatan -</option>
                                    <option value="PM">Paket Meeting</option>
                                    <option value="LB">Lembur</option>
                                    <option value="PD">Perjalanan Dinas</option>
                                </select>
                            </h4>
                        </div> --}}
                        {{-- card body --}}
                        <div class="card-body">
                            @if ($daftarBerkas->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama dan Pagu Kegiatan</th>
                                                <th>Status Verifikasi</th>
                                                <th>Catatan Verifikator</th>
                                                <th>Berkas Kegiatan</th>
                                                <th>Aksi</th>
                                            </tr>
                                            @foreach ($daftarBerkas->paginate(20) as $index => $berkas)
                                                <tr>
                                                    <td width="3%">{{ $index + 1 }}</td>
                                                    {{-- FIXME: undefined offset 0 selain admin --}}
                                                    {{-- array_keys(array_filter($berkas->getRelations()))[0] --}}
                                                    @switch(array_keys(array_filter($berkas->getRelations()))[0])
                                                        @case('paketMeetingRelationship')
                                                            @include('livewire.berkas.pengumpulan.template', [
                                                                'activity' => $berkas->paketMeetingRelationship,
                                                                'model'    => $berkas
                                                            ])
                                                            @break
                                                        @case('lemburRelationship')
                                                            @include('livewire.berkas.pengumpulan.template', [
                                                                'activity' => $berkas->lemburRelationship,
                                                                'model'    => $berkas
                                                            ])
                                                            @break
                                                        @case('perjadinRelationship')
                                                            @include('livewire.berkas.pengumpulan.template', [
                                                                'activity' => $berkas->perjadinRelationship,
                                                                'model'    => $berkas
                                                            ])
                                                            @break
                                                    @endswitch
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $daftarBerkas->paginate(20)->links('vendor.pagination.sipangadu') }}
                            @else
                                @include('components.notification.not-found', [
                                    'data_height' => 400,
                                    'description' => "Maaf, kami tidak dapat menemukan data apapun."
                                ])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
