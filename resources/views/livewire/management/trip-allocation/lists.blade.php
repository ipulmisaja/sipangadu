@section('title', 'Alokasi Perjalanan Dinas')

<div class="main-content">
    {{-- Section --}}
    <section class="section" style="z-index:0">
        <div class="section-header">
            <p class="h3">Daftar Volume Perjalanan Dinas</p>
        </div>
        <div class="section-body">
            {{-- Notification --}}
            @include('components.notification.flash')

            <div class="card border rounded">
                <div class="card-header">
                    <h4>
                        <a href="{{ url(env('APP_URL') . 'tata-kelola/alokasi-perjalanan-dinas/buat') }}" class="btn btn-icon icon-left btn-primary">
                            <i class="fas fa-plus"></i>
                            <span class="ml-1">Lakukan Alokasi Perjalanan Dinas</span>
                        </a>
                    </h4>
                    <div class="card-header-form">
                        <select wire:model="view" class="form-control">
                            <option value="1">Perjalan Dinas per Unit Kerja</option>
                            <option value="2">Alokasi Menurut Kegiatan</option>
                            <option value="3">Alokasi Menurut Pegawai</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    @switch($view)
                        @case(1)
                            @if ($tripVolumeList->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th>Tahun</th>
                                            <th>Unit Kerja</th>
                                            <th>Kode dan Deskripsi Anggaran</th>
                                            <th>Volume</th>
                                            <th>Harga Satuan</th>
                                            <th>Jumlah Anggaran</th>
                                        </tr>

                                        @foreach ($tripVolumeList->paginate(10) as $index => $tripVolumeItem)
                                            <tr>
                                                @if ($index == 0)
                                                    <td>{{ $tripVolumeItem->tahun }}</td>
                                                @else
                                                    <td></td>
                                                @endif
                                                <td>{{ $tripVolumeItem->unit->nama }}</td>
                                                <td>
                                                    <div class="pt-3">
                                                        <label class="font-weight-bold">Kegiatan : </label><br>
                                                        <div class="ml-4">
                                                            <span class="font-weight-bold text-primary">
                                                                {{
                                                                    "054.01." .
                                                                    $tripVolumeItem->kd_program . '.' .
                                                                    $tripVolumeItem->kd_kegiatan
                                                                }}
                                                            </span><br>
                                                            <span>
                                                                {{
                                                                    \App\Models\Pok::query()
                                                                        ->where('kd_kegiatan', $tripVolumeItem->kd_kegiatan)
                                                                        ->where('kd_kro', '000')
                                                                        ->pluck('deskripsi')[0]
                                                                }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="py-3">
                                                        <label class="font-weight-bold">Output : </label><br>
                                                        <div class="ml-4">
                                                            <span class="font-weight-bold text-primary">
                                                                {{
                                                                    $tripVolumeItem->kd_kegiatan . '.' .
                                                                    $tripVolumeItem->kd_kro . '.' .
                                                                    $tripVolumeItem->kd_ro
                                                                }}
                                                            </span><br>
                                                            <span>
                                                                {{
                                                                    \App\Models\Pok::query()
                                                                        ->where('kd_kegiatan', $tripVolumeItem->kd_kegiatan)
                                                                        ->where('kd_kro', $tripVolumeItem->kd_kro)
                                                                        ->where('kd_ro', $tripVolumeItem->kd_ro)
                                                                        ->where('kd_komponen', '000')
                                                                        ->pluck('deskripsi')[0]
                                                                }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="pb-3">
                                                        <label class="font-weight-bold">Deskripsi : </label><br>
                                                        <div class="ml-4">
                                                            <span class="font-weight-bold text-primary">
                                                                {{
                                                                    $tripVolumeItem->kd_komponen . '.' .
                                                                    $tripVolumeItem->kd_subkomponen . '.' .
                                                                    $tripVolumeItem->kd_akun
                                                                }}
                                                            </span><br>
                                                            <span>{{ $tripVolumeItem->deskripsi }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $tripVolumeItem->volume . ' ' . $tripVolumeItem->satuan }}</td>
                                                <td>Rp. {{ number_format($tripVolumeItem->harga_satuan, 0, ',', '.') }},-</td>
                                                <td>Rp. {{ number_format($tripVolumeItem->total, 0, ',', '.') }},-</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="mt-2">
                                    {{ $tripVolumeList->paginate(10)->links('vendor.pagination.sipangadu') }}
                                </div>
                            @else
                                @include('components.notification.not-found', [
                                    'data_height' => 400,
                                    'description' => "Maaf, kami tidak dapat menemukan data apapun, " .
                                                        "untuk menghilangkan pesan ini, buat alokasi perjalanan dinas."
                                ])
                            @endif

                            @break
                        @case(2)
                            @if ($tripAllocationList->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr style="background-color: rgba(0,0,0,.02)">
                                            <th>Tahun</th>
                                            <th>Nama Kegiatan</th>
                                            <th>Jumlah</th>
                                            <th>Alokasi Pegawai</th>
                                        </tr>

                                        @for ($i = 0; $i < $tripAllocationList->count(); $i++)
                                            @if ($i == 0)
                                                <tr>
                                                    <td>
                                                        {{ $tripAllocationList[$i]->year }}
                                                    </td>
                                                    <td>
                                                        <div class="pt-3">
                                                            <label class="font-weight-bold">Kegiatan :</label><br>
                                                            <div class="ml-4">
                                                                <span class="font-weight-bold text-primary">
                                                                    {{
                                                                        "054.01." .
                                                                        $tripAllocationList[$i]->pokRelationship->kd_program . '.' .
                                                                        $tripAllocationList[$i]->pokRelationship->kd_kegiatan
                                                                    }}
                                                                </span><br>
                                                                <span>
                                                                    {{
                                                                        \App\Models\Pok::query()
                                                                            ->where('kd_kegiatan', $tripAllocationList[$i]->pokRelationship->kd_kegiatan)
                                                                            ->where('kd_kro', '000')
                                                                            ->pluck('deskripsi')[0]
                                                                    }}
                                                                </span>
                                                            </div>
                                                            <div class="py-3">
                                                                <label class="font-weight-bold">Output : </label><br>
                                                                <div class="ml-4">
                                                                    <span class="font-weight-bold text-primary">
                                                                        {{
                                                                            $tripAllocationList[$i]->pokRelationship->kd_kegiatan . '.' .
                                                                            $tripAllocationList[$i]->pokRelationship->kd_kro . '.' .
                                                                            $tripAllocationList[$i]->pokRelationship->kd_ro
                                                                        }}
                                                                    </span><br>
                                                                    <span>
                                                                        {{
                                                                            \App\Models\Pok::query()
                                                                                ->where('kd_kegiatan', $tripAllocationList[$i]->pokRelationship->kd_kegiatan)
                                                                                ->where('kd_kro', $tripAllocationList[$i]->pokRelationship->kd_kro)
                                                                                ->where('kd_ro', $tripAllocationList[$i]->pokRelationship->kd_ro)
                                                                                ->where('kd_komponen', '000')
                                                                                ->pluck('deskripsi')[0]
                                                                        }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="pb-3">
                                                                <label class="font-weight-bold">Deskripsi : </label><br>
                                                                <div class="ml-4">
                                                                    <span class="font-weight-bold text-primary">
                                                                        {{
                                                                            $tripAllocationList[$i]->pokRelationship->kd_komponen . '.' .
                                                                            $tripAllocationList[$i]->pokRelationship->kd_subkomponen . '.' .
                                                                            $tripAllocationList[$i]->pokRelationship->kd_akun
                                                                        }}
                                                                    </span><br>
                                                                    <span>{{ $tripAllocationList[$i]->pokRelationship->deskripsi }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{
                                                            $tripAllocationList[$i]->pokRelationship->volume . ' ' .
                                                            $tripAllocationList[$i]->pokRelationship->satuan
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                            $tripAllocationList[$i]->userRelationship->nama .
                                                            ' (' . $tripAllocationList[$i]->total . ' ' . $tripAllocationList[$i]->pokRelationship->satuan . ')'
                                                        }}
                                                    </td>
                                                </tr>
                                            @else
                                                @if ($tripAllocationList[$i]->pok_id !== $tripAllocationList[$i-1]->pok_id)
                                                    <tr>
                                                        <td>{{ $tripAllocationList[$i]->year }}</td>
                                                        <td>
                                                            <div class="pt-3">
                                                                <label class="font-weight-bold">Kegiatan :</label><br>
                                                                <div class="ml-4">
                                                                    <span class="font-weight-bold text-primary">
                                                                        {{
                                                                            "054.01." .
                                                                            $tripAllocationList[$i]->pokRelationship->kd_program . '.' .
                                                                            $tripAllocationList[$i]->pokRelationship->kd_kegiatan
                                                                        }}
                                                                    </span><br>
                                                                    <span>
                                                                        {{
                                                                            \App\Models\Pok::query()
                                                                                ->where('kd_kegiatan', $tripAllocationList[$i]->pokRelationship->kd_kegiatan)
                                                                                ->where('kd_kro', '000')
                                                                                ->pluck('deskripsi')[0]
                                                                        }}
                                                                    </span>
                                                                </div>
                                                                <div class="py-3">
                                                                    <label class="font-weight-bold">Output : </label><br>
                                                                    <div class="ml-4">
                                                                        <span class="font-weight-bold text-primary">
                                                                            {{
                                                                                $tripAllocationList[$i]->pokRelationship->kd_kegiatan . '.' .
                                                                                $tripAllocationList[$i]->pokRelationship->kd_kro . '.' .
                                                                                $tripAllocationList[$i]->pokRelationship->kd_ro
                                                                            }}
                                                                        </span><br>
                                                                        <span>
                                                                            {{
                                                                                \App\Models\Pok::query()
                                                                                    ->where('kd_kegiatan', $tripAllocationList[$i]->pokRelationship->kd_kegiatan)
                                                                                    ->where('kd_kro', $tripAllocationList[$i]->pokRelationship->kd_kro)
                                                                                    ->where('kd_ro', $tripAllocationList[$i]->pokRelationship->kd_ro)
                                                                                    ->where('kd_komponen', '000')
                                                                                    ->pluck('deskripsi')[0]
                                                                            }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="pb-3">
                                                                    <label class="font-weight-bold">Deskripsi : </label><br>
                                                                    <div class="ml-4">
                                                                        <span class="font-weight-bold text-primary">
                                                                            {{
                                                                                $tripAllocationList[$i]->pokRelationship->kd_komponen . '.' .
                                                                                $tripAllocationList[$i]->pokRelationship->kd_subkomponen . '.' .
                                                                                $tripAllocationList[$i]->pokRelationship->kd_akun
                                                                            }}
                                                                        </span><br>
                                                                        <span>{{ $tripAllocationList[$i]->pokRelationship->deskripsi }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            {{
                                                                $tripAllocationList[$i]->pokRelationship->volume . ' ' .
                                                                $tripAllocationList[$i]->pokRelationship->satuan
                                                            }}
                                                        </td>
                                                        <td>
                                                            {{
                                                                $tripAllocationList[$i]->userRelationship->nama .
                                                                ' (' . $tripAllocationList[$i]->total . ' ' . $tripAllocationList[$i]->pokRelationship->satuan . ')'
                                                            }}
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            {{
                                                                $tripAllocationList[$i]->userRelationship->name .
                                                                ' (' . $tripAllocationList[$i]->total . ' ' . $tripAllocationList[$i]->pokRelationship->satuan . ')'
                                                            }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                        @endfor
                                    </table>
                                </div>
                                <div class="mt-2">
                                    {{ $tripAllocationList->paginate(15)->links('vendor.pagination.sipangadu') }}
                                </div>
                            @else
                                @include('components.notification.not-found', [
                                    'data_height' => 400,
                                    'description' => "Maaf, kami tidak dapat menemukan data apapun, " .
                                                        "untuk menghilangkan pesan ini, buat alokasi perjalanan dinas."
                                ])
                            @endif

                            @break
                        @case(3)
                            @if ($tripEmployeeList->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr style="background-color: rgba(0,0,0,.02)">
                                        <th>Tahun</th>
                                        <th>Nama Pegawai</th>
                                        <th>Alokasi Perjalanan Dinas Pada Kegiatan</th>
                                        <th>Total Perjalanan Dinas</th>
                                    </tr>

                                    @foreach ($tripEmployeeList->paginate(10) as $tripEmployeeItem)
                                        <tr>
                                            <td>{{ $tripEmployeeItem->alokasiPerjadinRelationship[0]->year ?? '-' }}</td>
                                            <td>{{ $tripEmployeeItem->nama }}</td>
                                            <td>
                                                <div class="pt-3">
                                                    <label class="font-weight-bold">Kegiatan : </label><br>
                                                    @if ($tripEmployeeItem->alokasiPerjadinRelationship->count() > 0)
                                                        @foreach ($tripEmployeeItem->alokasiPerjadinRelationship as $item)
                                                            <div class="ml-4">
                                                                <div class="mb-3">
                                                                    <span class="font-weight-bold text-primary">
                                                                        {{
                                                                            "054.01" .
                                                                            $item->pokRelationship->kd_program . '.' .
                                                                            $item->pokRelationship->kd_kegiatan . '.' .
                                                                            $item->pokRelationship->kd_kro . '.' .
                                                                            $item->pokRelationship->kd_ro . '.' .
                                                                            $item->pokRelationship->kd_komponen . '.' .
                                                                            $item->pokRelationship->kd_subkomponen . '.' .
                                                                            $item->pokRelationship->kd_akun
                                                                        }}
                                                                    </span><br>
                                                                    <span>
                                                                        {{
                                                                            $item->pokRelationship->deskripsi . ' (Alokasi ' . $item->total . ' ' . $item->pokRelationship->satuan . ')'
                                                                        }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="ml-4">
                                                            <div class="pb-2">
                                                                <span class="font-weight-bold text-primary">-</span><br>
                                                                <span>-</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                {{ $tripEmployeeItem->alokasiPerjadinRelationship->count() }} kali
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="mt-2">
                                {{ $tripEmployeeList->paginate(10)->links('vendor.pagination.sipangadu') }}
                            </div>
                        @else
                            @include('components.notification.not-found', [
                                'data_height' => 400,
                                'description' => "Maaf, kami tidak dapat menemukan data apapun, " .
                                                    "untuk menghilangkan pesan ini, buat alokasi perjalanan dinas."
                            ])
                        @endif

                            @break
                    @endswitch

                </div>
            </div>
        </div>
    </section>
</div>
