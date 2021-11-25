@section('title', 'Tindak Lanjut')

<div class="main-content">
    {{-- Section --}}
    <section class="section" style="z-index:0">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">Tindak Lanjut Pengajuan Kegiatan</p>
        </div>

        {{-- Body --}}
        <div class="section-body">
            {{-- Notification --}}
            @include('components.notification.flash')

            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">
                        <div class="card-header">
                            <h4>
                                <select class="form-control">
                                    <option value="null">- Pilih Jenis Kegiatan -</option>
                                    <option value="FB">Paket Meeting</option>
                                    <option value="LB">Lembur</option>
                                    <option value="PD">Perjalanan Dinas</option>
                                </select>
                            </h4>
                            <div class="card-header-form d-flex">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button wire:click="undone" type="button" class="btn {{ $status === 'undone' ? 'btn-primary' : 'btn-outline-primary' }}">Belum Tindak Lanjut <b>({{ $jumlahTindakLanjut[0] }})</b></button>
                                    <button wire:click="done" type="button" class="btn {{ $status === 'done' ? 'btn-primary' : 'btn-outline-primary' }}">Selesai Tindak Lanjut <b>({{ $jumlahTindakLanjut[1] }})</b></button>
                                </div>
                                <div class="mx-3 border-left"></div>
                                <form>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Cari">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($tindakLanjut->count() > 0)
                                <div class="table-responsive border rounded">
                                    <table class="table table-striped table-bordered">
                                        <tbody>
                                            {{-- Columns --}}
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nama Kegiatan</th>
                                                <th>Pagu Kegiatan</th>
                                                <th>Pengusul</th>
                                                <th>Aksi</th>
                                            </tr>

                                            {{-- Content --}}

                                            @foreach ($tindakLanjut->paginate(20) as $item)
                                                @php
                                                    $relationship = getModelRelationship($item->reference_id)['relationship'];
                                                @endphp
                                                <tr>
                                                    <td width="12%">
                                                        {{ DateFormat::convertDateTime($item->tanggal_dibuat ) }}
                                                    </td>
                                                    <td class="py-3" width="30%">
                                                        <div class="bg-warning py-1 px-2 rounded text-white mb-2" style="display: inline-block">
                                                            {{ getModelRelationship($item->reference_id)['name'] }}
                                                        </div><br>
                                                        {{ $item->$relationship->nama }}
                                                    </td>
                                                    <td width="30%">
                                                        <label class="font-weight-bold text-primary">
                                                            {{
                                                                '054.01.' .
                                                                $item->$relationship->pokRelationship->kd_program . "." .
                                                                $item->$relationship->pokRelationship->kd_kegiatan . "." .
                                                                $item->$relationship->pokRelationship->kd_kro . "." .
                                                                $item->$relationship->pokRelationship->kd_ro . "." .
                                                                $item->$relationship->pokRelationship->kd_komponen . "." .
                                                                $item->$relationship->pokRelationship->kd_subkomponen . "." .
                                                                $item->$relationship->pokRelationship->kd_akun . "." .
                                                                $item->$relationship->pokRelationship->kd_detail
                                                            }}
                                                        </label><br>
                                                        <span>{{ $item->$relationship->pokRelationship->deskripsi }}</span>
                                                    </td>
                                                    <td>
                                                        <i class="fa fa-user"></i>
                                                        <span class="ml-2">{{ $item->$relationship->pemeriksaanRelationship->userRelationship->nama }}</span>
                                                    </td>
                                                    <td>
                                                        <a
                                                            href="{{ url(env('APP_URL') . 'tindak-lanjut/detail/' . $item->reference_id) }}"
                                                            class="btn btn-icon btn-info"
                                                            data-toggle="tooltip"
                                                            data-placement="bottom"
                                                            title=""
                                                            data-original-title="Lihat">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @if (auth()->user()->hasUnit('kepeghum'))
                                                        @elseif (auth()->user()->hasUnit('keuangan'))
                                                            @if ($item->status_keuangan == 1)
                                                                <a
                                                                    wire:click="followup('{{ $item->reference_id }}', {{ $item->status_keuangan }}, 'keuangan')"
                                                                    class="ml-2 btn btn-icon btn-danger text-white"
                                                                    data-toggle="tooltip"
                                                                    data-placement="bottom"
                                                                    title=""
                                                                    data-original-title="Batalkan Tindak Lanjut">
                                                                    <i class="fas fa-times-circle"></i>
                                                                </a>
                                                            @else
                                                                <a
                                                                    wire:click="followup('{{ $item->reference_id }}', {{ $item->status_keuangan }}, 'keuangan')"
                                                                    class="ml-2 btn btn-icon btn-warning text-white"
                                                                    data-toggle="tooltip"
                                                                    data-placement="bottom"
                                                                    title=""
                                                                    data-original-title="Tandai Selesai Tindak Lanjut">
                                                                    <i class="fas fa-check-circle"></i>
                                                                </a>
                                                            @endif
                                                        @elseif (auth()->user()->hasUnit('pengadaan-barjas'))
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $tindakLanjut->paginate(20)->links('vendor.pagination.sipangadu') }}
                            @else
                                @include('components.notification.not-found', [
                                    'data_height' => 200,
                                    'description' => "Maaf, kami tidak dapat menemukan data apa pun, " .
                                                        "untuk menghilangkan pesan ini, buat setidaknya 1 pengajuan baru."
                                ])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
