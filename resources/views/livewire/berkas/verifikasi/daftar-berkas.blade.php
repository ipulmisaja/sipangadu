@section('title', 'Daftar Verifikasi Berkas')

<div class="main-content">
    <section class="section" style="z-index:0">
        <div class="section-header">
            <p class="h3">Daftar Verifikasi Berkas</p>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="border card rounded">
                        {{-- Card Header --}}
                        {{-- <div class="card-header">
                            <h4 class="w-25">
                                <select wire:model="activityType" class="form-control">
                                    <option value>- Seluruh Kegiatan -</option>
                                    <option value="FB">Paket Meeting</option>
                                    <option value="LB">Lembur</option>
                                    <option value="PD">Perjalanan Dinas</option>
                                </select>
                            </h4>
                        </div> --}}

                        {{-- Card Body --}}
                        <div class="card-body">
                            @if ($daftarVerifikasi->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Kegiatan</th>
                                                <th>Kode Anggaran</th>
                                                <th>Status Verifikasi</th>
                                                <th>Pengumpulan Berkas Fisik</th>
                                                <th>{{ $role === 'ppk' ? 'Catatan Verifikator' : 'Aksi' }}</th>
                                            </tr>

                                            @foreach ($daftarVerifikasi->paginate(20) as $index => $verifikasi)
                                                <tr>
                                                    <td width="3%">{{ $index + 1 }}</td>
                                                    @switch(array_keys(array_filter($verifikasi->getRelations()))[0])
                                                        @case('paketMeetingRelationship')
                                                            @include('livewire.berkas.verifikasi.template', [
                                                                'kegiatan' => $verifikasi->paketMeetingRelationship,
                                                                'berkas'   => $verifikasi,
                                                                'role'     => $role
                                                            ])
                                                            @break
                                                        @case('lemburRelationship')
                                                            @include('livewire.berkas.verifikasi.template', [
                                                                'kegiatan' => $verifikasi->lemburRelationship,
                                                                'berkas'   => $verifikasi,
                                                                'role'     => $role
                                                            ])
                                                            @break
                                                        @case('perjadinRelationship')
                                                            @include('livewire.berkas.verifikasi.template', [
                                                                'kegiatan' => $verifikasi->perjadinRelationship,
                                                                'berkas'   => $verifikasi,
                                                                'role'     => $role
                                                            ])
                                                            @break
                                                    @endswitch
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $daftarVerifikasi->paginate(20)->links('vendor.pagination.sipangadu') }}
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
