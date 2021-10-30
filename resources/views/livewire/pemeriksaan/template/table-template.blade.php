@if (count($model) > 0)
    <div class="table-responsive border rounded">
        <table class="table table-striped table-bordered">
            <tbody>
                {{-- Columns --}}
                <tr>
                    <th>Jenis Kegiatan</th>
                    <th>Nama Kegiatan</th>
                    <th>Pagu Kegiatan</th>
                    <th>Pengusul</th>
                    <th>Aksi</th>
                </tr>

                {{-- Content --}}
                @foreach ($model->paginate(20) as $item)
                    @php
                        $relationship = getModelRelationship($item->reference_id)['relationship']
                    @endphp
                    <tr>
                        <td>
                            <span class="badge {{ getModelRelationship($item->reference_id)['badge'] }}">
                                {{ getModelRelationship($item->reference_id)['name'] }}
                            </span>
                        </td>
                        <td class="py-3">
                            <span class="font-weight-bold">
                                <i class="fas fa-calendar"></i>
                                <span class="ml-2">
                                    {{ DateFormat::convertDateTime($item->tanggal_pengajuan) }}
                                </span>
                            </span><br>
                            {{ $item->$relationship->nama }}
                        </td>
                        <td>
                            <span class="font-weight-bold">
                                <i class="fas fa-coins"></i>
                                <span class="ml-2">
                                    {{
                                        '054.01.' .
                                        $item->$relationship->pokRelationship->kd_program . "." .
                                        $item->$relationship->pokRelationship->kd_kegiatan . "." .
                                        $item->$relationship->pokRelationship->kd_kro . "." .
                                        $item->$relationship->pokRelationship->kd_ro . "." .
                                        $item->$relationship->pokRelationship->kd_komponen . "." .
                                        $item->$relationship->pokRelationship->kd_subkomponen . "." .
                                        $item->$relationship->pokRelationship->kd_akun
                                    }}
                                </span>
                            </span><br>
                            <span>{{ $item->$relationship->pokRelationship->deskripsi }}</span>
                        </td>
                        <td>
                            <i class="fa fa-user"></i>
                            <span class="ml-2">{{ $item->userRelationship->nama }}</span>
                        </td>
                        <td>
                            <a
                                href="{{ url(env('APP_URL') . 'pemeriksaan/' . $item->reference_id . '/' . $role) }}"
                                class="btn btn-icon btn-primary"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                title=""
                                data-original-title="Periksa">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-2">
        {{ $model->paginate(20)->links('vendor.pagination.sipangadu') }}
    </div>
@else
    @if ($role === 'ppk')
        <div class="mt-5"></div>
        @include('components.notification.not-found', [
            'data_height' => 200,
            'description' => "Maaf, data pemeriksaan pengajuan belanja belum ada."
        ])
    @else
        @include('components.notification.not-found', [
            'data_height' => 200,
            'description' => "Maaf, data pemeriksaan pengajuan belanja belum ada."
        ])
    @endif
@endif
