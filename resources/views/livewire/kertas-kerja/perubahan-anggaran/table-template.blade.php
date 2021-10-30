@if ($data->count() > 0)
    @php
        $model  = \App\Models\Pok::query()
                -> whereIn('id', $data[0]->pok_id)
                -> get();

        $header = \App\Models\Pok::query()
                -> where('kd_kegiatan', $model[0]->kd_kegiatan)
                -> where('kd_kro', $model[0]->kd_kro)
                -> where('kd_ro', $model[0]->kd_ro)
                -> where('kd_komponen', '000')
                -> first();
    @endphp

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <tbody>
                {{-- Columns --}}
                <tr>
                    <th>Kode dan Deskripsi Anggaran</th>
                    <th>Pengusul Anggaran</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Aksi</th>
                </tr>

                {{-- Content --}}
                @foreach ($data as $item)
                    <tr>
                        <td class="py-3">
                            <label class="font-weight-bold text-primary">
                                {{
                                    $header->kd_kegiatan . '.' .
                                    $header->kd_kro . '.' .
                                    $header->kd_ro
                                }}
                            </label>
                            <p class="h6 font-weight-bold">{{ $header->deskripsi }}</p>
                            <hr class="text-muted" style="border-top:dotted">
                            <ol>
                                @foreach ($model as $singlemodel)
                                    <li>
                                        <label class="font-weight-bold text-warning">
                                            Komponen ({{ $singlemodel->kd_komponen }})
                                        </label>
                                        <p class="h6">
                                            {{ ucwords(strtolower($singlemodel->deskripsi)) }}
                                        </p>
                                    </li>
                                @endforeach
                            </ol>
                        </td>
                        <td>
                            <i class="fa fa-user"></i>
                            <span class="ml-2">
                                {{ \App\Models\User::where('id', $item->user_id)->first('nama')->nama }}
                            </span>
                        </td>
                        <td>
                            <i class="fa fa-calendar"></i>
                            <span class="ml-2">
                                {{ DateFormat::convertDateTime($item->tanggal_pengajuan) }}
                            </span>
                        </td>
                        <td>
                            <a
                                href="{{ google_view_file($item->file) }}"
                                target="_blank"
                                class="btn btn-icon icon-left btn-info"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                title=""
                                data-original-title="Unduh MSM">
                                <i class="fa fa-download"></i>
                            </a>
                            <a
                                href="{{ url(env('APP_URL') . 'kertas-kerja/pemeriksaan-msm/' . $item->reference_id . '/' . $role . '/detail') }}"
                                class="ml-2 ml-2 btn btn-icon btn-primary"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                title=""
                                data-original-title="Periksa MSM">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    @include('components.notification.not-found', [
        'data_height' => 400,
        'description' => "Maaf, data usulan perubahan anggaran belum tersedia."
    ])
@endif
