@section('title', 'Alokasi Anggaran')

<div class="main-content">
    {{-- Section --}}
    <section class="section" style="z-index:0">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">Alokasi Anggaran Menurut Fungsi/Bagian</p>
        </div>

        {{-- Body --}}
        <div class="section-body">
            @include('components.notification.flash')

            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">
                        {{-- Card Header --}}
                        <div class="card-header">
                            <h4>
                                <a
                                    href="{{ url(env('APP_URL') . 'kertas-kerja/alokasi-anggaran/buat') }}"
                                    class="btn btn-icon icon-left btn-primary">
                                    <i class="fa fa-plus"></i>
                                    Lakukan Alokasi Anggaran
                                </a>
                            </h4>
                            <div class="card-header-form">
                                <select wire:model="year" class="form-control">
                                    <option value="last">- Pilih Tahun -</option>
                                    @foreach ($listYear as $year)
                                        <option value="{{ $year->tahun }}">{{ $year->tahun }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body">
                            @if ($listPokAllocation->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <tbody>
                                            {{-- Columns --}}
                                            <tr>
                                                <th>Tahun</th>
                                                <th>Unit Kerja</th>
                                                <th>Kegiatan</th>
                                                <th>Jumlah Anggaran</th>
                                            </tr>

                                            {{-- Content --}}
                                            @for ($i = 0; $i < $listPokAllocation->count(); $i++)
                                                @if ($i == 0)
                                                    <tr>
                                                        <td>{{ $listPokAllocation[$i]->tahun }}</td>
                                                        <td>
                                                            {{ $listPokAllocation[$i]->unit->nama }}
                                                        </td>
                                                        <td>
                                                            <span class="font-weight-bold text-primary">
                                                                {{
                                                                    $listPokAllocation[$i]->kd_departemen . "." .
                                                                    $listPokAllocation[$i]->kd_organisasi . "." .
                                                                    $listPokAllocation[$i]->kd_program . "." .
                                                                    $listPokAllocation[$i]->kd_kegiatan
                                                                }}
                                                            </span><br>
                                                            <span>
                                                                {{ $listPokAllocation[$i]->deskripsi }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            Rp. {{ number_format($listPokAllocation[$i]->total ,0, ',', '.') }},-
                                                        </td>
                                                    </tr>
                                                @else
                                                    @if($listPokAllocation[$i]->unit_id !== $listPokAllocation[$i-1]->unit_id)
                                                        <tr>
                                                            <td></td>
                                                            <td>
                                                                {{ $listPokAllocation[$i]->unit->nama }}
                                                            </td>
                                                            <td>
                                                                <span class="font-weight-bold text-primary">
                                                                    {{
                                                                        $listPokAllocation[$i]->kd_departemen . "." .
                                                                        $listPokAllocation[$i]->kd_organisasi . "." .
                                                                        $listPokAllocation[$i]->kd_program . "." .
                                                                        $listPokAllocation[$i]->kd_kegiatan
                                                                    }}
                                                                </span><br>
                                                                <span>
                                                                    {{ $listPokAllocation[$i]->deskripsi }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                Rp. {{ number_format($listPokAllocation[$i]->total ,0, ',', '.') }},-
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td>
                                                                <span class="font-weight-bold text-primary">
                                                                    {{
                                                                        $listPokAllocation[$i]->kd_departemen . "." .
                                                                        $listPokAllocation[$i]->kd_organisasi . "." .
                                                                        $listPokAllocation[$i]->kd_program . "." .
                                                                        $listPokAllocation[$i]->kd_kegiatan
                                                                    }}
                                                                </span><br>
                                                                <span>
                                                                    {{ $listPokAllocation[$i]->deskripsi }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                Rp. {{ number_format($listPokAllocation[$i]->total ,0, ',', '.') }},-
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                @include('components.notification.not-found', [
                                    'data_height' => 400,
                                    'description' => "Maaf, kami tidak dapat menemukan data apapun, " .
                                                    "untuk menghilangkan pesan ini, alokasikan anggaran setidaknya 1 kegiatan."
                                ])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
