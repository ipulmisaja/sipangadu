@section('title', 'Alokasi Anggaran')

<div class="main-content">
    {{-- Section --}}
    <section class="section">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">Alokasi Anggaran Kegiatan - POK Tahun {{ $activityList[0]->tahun }}</p>
        </div>

        {{-- Body --}}
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <form method="POST" action="{{ route('pok.allocation.save') }}">
                        @csrf
                        <div class="bg-white border-left border-top border-right rounded-top">
                            <div class="card-body">
                                @if ($activityList->count() > 0)
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card-body p-0">
                                                <div class="rounded">
                                                    <table class="table table-striped table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <th>Kode dan Uraian Kegiatan</th>
                                                                <th>Besar Pagu</th>
                                                                <th>Pemilik Pagu</th>
                                                            </tr>

                                                            @foreach ($activityList as $item)
                                                                <tr>
                                                                    <td class="py-3" style="width:50%">
                                                                        <label class="font-weight-bold text-primary">
                                                                            {{
                                                                                '054.01.' .
                                                                                $item->kd_program . "." .
                                                                                $item->kd_kegiatan
                                                                            }}
                                                                        </label>
                                                                        <p class="h6">
                                                                            {{ ucwords(strtolower($item->deskripsi)) }}
                                                                        </p>
                                                                    </td>
                                                                    <td style="width:20%">
                                                                        <i class="fa fa-coins"></i>
                                                                        <span class="ml-2 font-weight-bold">
                                                                            Rp. {{ number_format($item->total, 0, ',', '.') }},-
                                                                        </span>
                                                                    </td>
                                                                    <td style="width:30%">
                                                                        <select class="form-control" name="func_coord[]">
                                                                            <option value="pilih">- KF / Bagian -</option>
                                                                            @foreach ($list_kf as $kf)
                                                                                <option value="{{
                                                                                        $item->kd_program . "." .
                                                                                        $item->kd_kegiatan . "." .
                                                                                        $kf->id
                                                                                    }}">{{ $kf->nama }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if ($activityList->count() > 0)
                            <div id="btn-save" class="bg-secondary bg-footer py-3 pr-5 rounded-bottom">
                                <div class="d-flex">
                                    <span class="flex-fill"></span>
                                    <button class="btn btn-primary">
                                        <i class="far fa-save"></i>
                                        <span>Simpan</span>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
