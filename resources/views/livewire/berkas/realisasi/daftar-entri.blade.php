@section('title', 'Realisasi Anggaran')

<div class="main-content">
    <section class="section" style="z-index:0">
        <div class="section-header">
            <p class="h3">Daftar Realisasi Anggaran</p>
        </div>

        <div class="section-body">
            @include('components.notification.flash')

            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">
                        <div class="card-header">
                            {{-- <h4 class="w-25">
                                <select wire:model="activityType" class="form-control">
                                    <option value>- Pilih Kegiatan -</option>
                                    <option value="PM">Paket Meeting</option>
                                    <option value="LB">Lembur</option>
                                    <option value="PD">Perjalanan Dinas</option>
                                </select>
                            </h4> --}}
                            <div class="card-header-form">
                                <a
                                    href="{{ url(env('APP_URL') . 'berkas/realisasi-anggaran/entri') }}"
                                    class="btn btn-icon icon-left btn-primary">
                                    <i class="fas fa-plus"></i>
                                    <span class="ml-1">Entri Realisasi</span>
                                </a>
                            </div>

                        </div>
                        <div class="card-body">
                            @if ($daftarRealisasi->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <th>Nama Kegiatan</th>
                                                <th>Pagu Kegiatan</th>
                                                <th>Approval PPK</th>
                                                <th>Jumlah Realisasi</th>
                                                <th>Aksi</th>
                                            </tr>
                                            @foreach ($daftarRealisasi->paginate(20) as $realizationItem)
                                                @if (!is_null($realizationItem->reference_id))
                                                    @php
                                                        $relationship = getModelRelationship($realizationItem->reference_id)['relationship'];
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <span>
                                                                {{ $realizationItem->$relationship->nama }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <label>
                                                                <i class="fas fa-coins"></i>
                                                                <span class="ml-1 text-primary font-weight-bold">
                                                                    {{
                                                                        "054.01." .
                                                                        $realizationItem->$relationship->pokRelationship->kd_program . "." .
                                                                        $realizationItem->$relationship->pokRelationship->kd_kegiatan . "." .
                                                                        $realizationItem->$relationship->pokRelationship->kd_kro . "." .
                                                                        $realizationItem->$relationship->pokRelationship->kd_ro . "." .
                                                                        $realizationItem->$relationship->pokRelationship->kd_komponen . "." .
                                                                        $realizationItem->$relationship->pokRelationship->kd_subkomponen . "." .
                                                                        $realizationItem->$relationship->pokRelationship->kd_akun
                                                                    }}
                                                                </span>
                                                            </label><br>
                                                            <span>{{ $realizationItem->$relationship->pokRelationship->deskripsi }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="badge {{ is_null($realizationItem->spm) ? 'badge-warning' : 'badge-primary' }}">
                                                                {{ is_null($realizationItem->spm) ? 'Belum Ada' : 'No. ' . $realizationItem->spm }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            Rp. {{ number_format($realizationItem->total, 0, ',', '.') }},-
                                                        </td>
                                                        <td>
                                                            <a
                                                                href="{{ url(env('APP_URL') . 'berkas/realisasi-anggaran/' . $realizationItem->id) }}"
                                                                class="btn btn-icon icon-left btn-primary"
                                                                data-toggle="tooltip"
                                                                data-placement="bottom"
                                                                title=""
                                                                data-original-title="Entri Realisasi">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td>
                                                            <span>Bukan Pengajuan Belanja</span>
                                                        </td>
                                                        <td>
                                                            <label>
                                                                <i class="fas fa-coins"></i>
                                                                <span class="ml-1 text-primary font-weight-bold">
                                                                    @php
                                                                        $pokId = \App\Models\Pok::where('id', $realizationItem->pok_id)->first();
                                                                    @endphp
                                                                    {{
                                                                        "054.01." .
                                                                        $pokId->kd_program . "." .
                                                                        $pokId->kd_kegiatan . "." .
                                                                        $pokId->kd_kro . "." .
                                                                        $pokId->kd_ro . "." .
                                                                        $pokId->kd_komponen . "." .
                                                                        $pokId->kd_subkomponen . "." .
                                                                        $pokId->kd_akun
                                                                    }}
                                                                </span>
                                                            </label><br>
                                                            <span>{{ $pokId->deskripsi }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="badge {{ is_null($realizationItem->spm) ? 'badge-warning' : 'badge-primary' }}">
                                                                {{ is_null($realizationItem->spm) ? 'Belum Ada' : 'No. ' . $realizationItem->spm }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            Rp. {{ number_format($realizationItem->total, 0, ',', '.') }},-
                                                        </td>
                                                        <td>
                                                            @if ($realizationItem->approve_ppk == 1)
                                                                <span class="badge badge-primary">Diterima PPK</span>
                                                            @else
                                                                <a
                                                                    href="{{ url(env('APP_URL') . 'berkas/realisasi-anggaran/' . $realizationItem->id) }}"
                                                                    class="btn btn-icon icon-left btn-primary"
                                                                    data-toggle="tooltip"
                                                                    data-placement="bottom"
                                                                    title=""
                                                                    data-original-title="Entri Realisasi">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $daftarRealisasi->paginate(20)->links('vendor.pagination.sipangadu') }}
                            @else
                                @include('components.notification.not-found', [
                                    'data_height' => 400,
                                    'description' => "Maaf, kami tidak dapat menemukan data apapun, " .
                                                    "untuk menghilangkan pesan ini, unggah setidaknya 1 pok."
                                ])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
