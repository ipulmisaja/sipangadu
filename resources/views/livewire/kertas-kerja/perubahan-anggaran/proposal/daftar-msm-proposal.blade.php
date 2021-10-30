@section('title', 'Usul Perubahan Anggaran')

<div class="main-content">
    {{-- Notification --}}
    @include('components.notification.flash')

    {{-- Section --}}
    <section class="section" style="z-index:0">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">Usul Perubahan Anggaran</p>
        </div>

        {{-- Body --}}
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">
                        {{-- Card Header --}}
                        <div class="card-header">
                            <h4>
                                <a href="{{ url(env('APP_URL') . 'kertas-kerja/msm/buat') }}" class="btn btn-icon icon-left btn-primary text-white">
                                    <i class="fa fa-plus"></i>
                                    Buat Usulan Baru
                                </a>
                            </h4>
                            <div class="card-header-form">
                                <form>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body p-0">
                            @if ($msmList->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <tbody>
                                            {{-- Columns --}}
                                            <tr>
                                                <th>
                                                    <div class="custom-checkbox custom-control text-center">
                                                        <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                                        <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                                    </div>
                                                </th>
                                                <th>Kode dan Deskripsi Anggaran</th>
                                                <th>Tanggal Pengajuan</th>
                                                <th>Keterangan Approval</th>
                                                <th>Aksi</th>
                                            </tr>

                                            {{-- Content --}}
                                            @foreach ($msmList as $proposal)
                                                <tr>
                                                    <td class="p-0 text-center">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-1">
                                                            <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                                        </div>
                                                    </td>
                                                    <td class="py-3">
                                                        @php
                                                            $model  = \App\Models\Pok::query()
                                                                      -> whereIn('id', $proposal->pok_id)
                                                                      -> get();

                                                            $header = \App\Models\Pok::query()
                                                                      -> where('kd_kegiatan', $model[0]->kd_kegiatan)
                                                                      -> where('kd_kro', $model[0]->kd_kro)
                                                                      -> where('kd_ro', $model[0]->kd_ro)
                                                                      -> where('kd_komponen', '000')
                                                                      -> first();
                                                        @endphp

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
                                                            @foreach ($model as $item)
                                                                <li>
                                                                    <label class="font-weight-bold text-warning">
                                                                        Komponen ({{ $item->kd_komponen }})
                                                                    </label>
                                                                    <p class="h6">
                                                                        {{ ucwords(strtolower($item->deskripsi)) }}
                                                                    </p>
                                                                </li>
                                                            @endforeach
                                                        </ol>
                                                    </td>
                                                    <td>
                                                        <i class="fa fa-calendar"></i>
                                                        <span class="ml-2">
                                                            {{ DateFormat::convertDateTime($proposal->tanggal_pengajuan) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @include('components.state.approval', [
                                                            'model' => $proposal,
                                                            'stage' => null
                                                        ])
                                                    </td>
                                                    <td>
                                                        <a
                                                            href="{{ url(env('APP_URL') . 'kertas-kerja/pengajuan-msm/'. $proposal->reference_id .'/detail') }}"
                                                            type="button"
                                                            class="btn btn-icon btn-info"
                                                            data-toggle="tooltip"
                                                            data-placement="bottom"
                                                            title=""
                                                            data-original-title="Lihat MSM">
                                                            <i class="far fa-eye"></i>
                                                        </a>
                                                        {{-- <button
                                                            type="button"
                                                            class="ml-2 btn btn-icon btn-primary"
                                                            data-toggle="tooltip"
                                                            data-placement="bottom"
                                                            title=""
                                                            data-original-title="Ubah Usulan MSM">
                                                            <i class="fas fa-edit"></i>
                                                        </button> --}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                @include('components.notification.not-found', [
                                    'data_height' => 400,
                                    'description' => "Maaf, kami tidak dapat menemukan data apa pun, " .
                                                     "untuk menghilangkan pesan ini, buat setidaknya 1 usulan baru."
                                ])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
