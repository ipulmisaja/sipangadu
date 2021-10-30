@if ($model->count() > 0)
    <div class="table-responsive border rounded">
        <table class="table table-striped table-bordered">
            <tbody>
                {{-- Columns --}}
                <tr>
                    <th>Nama Kegiatan</th>
                    <th>Kode dan Deskripsi Anggaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>

                {{-- Content --}}
                @foreach ($model->paginate(3) as $item)
                    <tr class="my-3">
                        <td>
                            <small class="text-muted font-weight-bold">
                                <i class="fa fa-calendar"></i>
                                <span class="ml-2">
                                    {{ DateFormat::convertDateTime($item->tanggal_pengajuan) }}
                                </span>
                            </small><br>
                            <span>{{ $item->nama }}</span>
                            </td>
                        <td>
                            <small class="text-muted font-weight-bold">
                                {{
                                    '054.01.' .
                                    $item->pokRelationship->kd_program . '.' .
                                    $item->pokRelationship->kd_kegiatan . '.' .
                                    $item->pokRelationship->kd_kro . '.' .
                                    $item->pokRelationship->kd_ro . '.' .
                                    $item->pokRelationship->kd_komponen . '.' .
                                    $item->pokRelationship->kd_subkomponen . '.' .
                                    $item->pokRelationship->kd_akun
                                }}
                            </small><br>
                            <span>{{ $item->pokRelationship->deskripsi }}</span>
                        </td>
                        <td>
                            @include('components.state.approval', [
                                'model' => $item,
                                'stage' => $stage
                            ])
                        </td>
                        <td>
                            <a
                                href="{{ route($route_detail, $item->reference_id) }}"
                                type="button"
                                class="btn btn-icon btn-info"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                title=""
                                data-original-title="Lihat">
                                <i class="far fa-eye"></i>
                            </a>
                            @if($item->approve_kf === 0)
                                <a
                                    href=""
                                    type="button"
                                    class="btn btn-icon btn-primary"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title=""
                                    data-original-title="Edit">
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
        {{ $model->paginate(3)->links('vendor.pagination.sipangadu') }}
    </div>
@else
    @include('components.notification.not-found', [
        'data_height' => 200,
        'description' => "Maaf, kami tidak dapat menemukan data apa pun, " .
                            "untuk menghilangkan pesan ini, buat setidaknya 1 pengajuan baru."
    ])
@endif
