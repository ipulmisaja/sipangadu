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
                            <h4></h4>
                            <div class="card-header-form">
                                <select class="form-control">
                                    <option value="null">- Pilih Jenis Kegiatan -</option>
                                    <option value="FB">Paket Meeting</option>
                                    <option value="LB">Lembur</option>
                                    <option value="PD">Perjalanan Dinas</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($tindakLanjut->count() > 0)
                                <div class="table-responsive border rounded">
                                    <table class="table table-striped table-bordered">
                                        <tbody>
                                            {{-- Columns --}}
                                            <tr>
                                                <th>Jenis Kegiatan</th>
                                                <th>Nama Kegiatan</th>
                                                <th>Pagu Kegiatan</th>
                                                <th>Pengusul Kegiatan</th>
                                                <th>Aksi</th>
                                            </tr>

                                            {{-- Content --}}

                                            @foreach ($tindakLanjut->paginate(20) as $item)
                                                @php
                                                    $relationship = getModelRelationship($item->reference_id)['relationship'];
                                                @endphp
                                                <tr>
                                                    <td width="10%">
                                                        <span class="badge {{ getModelRelationship($item->reference_id)['badge'] }}">
                                                            {{ getModelRelationship($item->reference_id)['name'] }}
                                                        </span>
                                                    </td>
                                                    <td class="py-3">
                                                        {{ $item->$relationship->nama }}
                                                    </td>
                                                    <td>
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
