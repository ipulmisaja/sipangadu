@section('title', 'Verifikasi Realisasi Anggaran')

<div class="main-content">
    <section class="section" style="z-index:0">
        <div class="section-header">
            <p class="h3">Daftar Verifikasi Realisasi Anggaran</p>
        </div>
        <div class="section-body">
            @include('components.notification.flash')

            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">
                        {{-- <div class="card-header">

                        </div> --}}
                        <div class="card-body" wire:poll.2s>
                            @if ($daftarVerifikasi->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <th>Nama Kegiatan</th>
                                                <th>Pagu Kegiatan</th>
                                                <th>Volume Realisasi</th>
                                                <th>Total</th>
                                                <th>Verifikasi</th>
                                            </tr>

                                            @foreach ($daftarVerifikasi->paginate(20) as $item)
                                                @if (!is_null($item->reference_id))
                                                    @php
                                                        $relationship = getModelRelationship($item->reference_id)['relationship'];
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <span>
                                                                {{ $item->$relationship->nama }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <label>
                                                                <i class="fas fa-coins"></i>
                                                                <span class="ml-1 text-primary font-weight-bold">
                                                                    {{
                                                                        "054.01." .
                                                                        $item->$relationship->pokRelationship->kd_program . "." .
                                                                        $item->$relationship->pokRelationship->kd_kegiatan . "." .
                                                                        $item->$relationship->pokRelationship->kd_kro . "." .
                                                                        $item->$relationship->pokRelationship->kd_ro . "." .
                                                                        $item->$relationship->pokRelationship->kd_komponen . "." .
                                                                        $item->$relationship->pokRelationship->kd_subkomponen . "." .
                                                                        $item->$relationship->pokRelationship->kd_akun
                                                                    }}
                                                                </span>
                                                            </label><br>
                                                            <span>{{ $item->$relationship->pokRelationship->deskripsi }}</span>
                                                        </td>
                                                        <td>
                                                            {{ $item->volume . " " . $item->$relationship->pokRelationship->satuan }}
                                                        </td>
                                                        <td>
                                                            Rp. {{ number_format($item->total, 0, ',', '.') }},-
                                                        </td>
                                                        <td>
                                                            <div class="custom-checkbox custom-control">
                                                                <input  type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-1">
                                                                <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                                            </div>
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
                                                                        $pokId = \App\Models\Pok::where('id', $item->pok_id)->first();
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
                                                            {{ $item->volume . " " . $pokId->satuan }}
                                                        </td>
                                                        <td>
                                                            Rp. {{ number_format($item->total, 0, ',', '.') }},-
                                                        </td>
                                                        <td>
                                                            <div class="form-check">
                                                                <input wire:click="verifikasi({{ $item->id }}, 'terima')" class="form-check-input" type="radio" name="diterima_{{ $item->id }}" id="diterima_{{ $item->id }}" @if($item->approve_ppk == 1) checked @endif>
                                                                <label class="form-check-label" for="diterima_{{ $item->id }}">Diterima</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input wire:click="verifikasi({{ $item->id }}, 'tolak')" class="form-check-input" type="radio" name="ditolak_{{ $item->id }}" id="ditolak_{{ $item->id }}" @if($item->approve_ppk == 2) checked @endif>
                                                                <label class="form-check-label" for="ditolak_{{ $item->id }}">Ditolak</label>
                                                            </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{ $daftarVerifikasi->paginate(20)->links('vendor.pagination.sipangadu') }}
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
