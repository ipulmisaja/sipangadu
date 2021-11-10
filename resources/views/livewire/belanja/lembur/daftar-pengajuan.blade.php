@section('title', 'Daftar Pengajuan Lembur')

<div class="main-content">
    <section class="section" style="z-index: 0">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">Daftar Pengajuan Lembur</p>
        </div>

        {{-- Content --}}
        <div class="section-body">
            {{-- Notifikasi --}}
            @include('components.notification.flash')

            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">
                        <div class="card-header">
                            <h4>
                                <a href="{{ url(env('APP_URL') . 'belanja/lembur/pengajuan') }}" class="btn btn-icon icon-left btn-primary text-white">
                                    <i class="fa fa-plus"></i>
                                    Ajukan Lembur
                                </a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    @if ($listLembur->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th>Tanggal Pengajuan</th>
                                                        <th>Nama Kegiatan</th>
                                                        <th>Pagu Kegiatan</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>

                                                    @foreach ($listLembur->paginate(20) as $item)
                                                        <tr>
                                                            <td width="12%">
                                                                {{ DateFormat::convertDateTime($item->pemeriksaanRelationship->tanggal_pengajuan) }}
                                                            </td>
                                                            <td>{{ $item->nama }}</td>
                                                            <td>
                                                                <span class="text-muted font-weight-bold">
                                                                    <i class="fas fa-coins"></i>
                                                                    <span class="ml-1">
                                                                        {{
                                                                            '054.01.' .
                                                                            $item->pokRelationship->kd_program . '.' .
                                                                            $item->pokRelationship->kd_kegiatan . '.' .
                                                                            $item->pokRelationship->kd_kro . '.' .
                                                                            $item->pokRelationship->kd_ro . '.' .
                                                                            $item->pokRelationship->kd_komponen . '.' .
                                                                            $item->pokRelationship->kd_subkomponen . '.' .
                                                                            $item->pokRelationship->kd_akun . '.' .
                                                                            $item->pokRelationship->kd_detail
                                                                        }}
                                                                    </span>
                                                                </span><br>
                                                                <span>{{ $item->pokRelationship->deskripsi }}</span>
                                                            </td>
                                                            <td>
                                                                @include('components.state.approval', [
                                                                    'model' => $item,
                                                                    'stage' => 'lembur'
                                                                ])
                                                            </td>
                                                            <td>
                                                                <a
                                                                    href="{{ url(env('APP_URL') . 'belanja/lembur/detail/' . $item->reference_id) }}"
                                                                    type="button"
                                                                    class="btn btn-icon btn-info"
                                                                    data-toggle="tooltip"
                                                                    data-placement="bottom"
                                                                    title=""
                                                                    data-original-title="Lihat">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                                @if ($item->approve_kf === 2 || $item->approve_ppk === 2)
                                                                    <a
                                                                        href=""
                                                                        type="button"
                                                                        class="btn btn-icon btn-primary ml-2"
                                                                        data-toggle="tooltip"
                                                                        data-placement="bottom"
                                                                        title=""
                                                                        data-original-title="Ajukan Ulang">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-3">
                                            {{ $listLembur->paginate(20)->links('vendor.pagination.sipangadu') }}
                                        </div>
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
            </div>
        </div>
    </section>
</div>
