@section('title', 'Petunjuk Operasional Kegiatan')

<div class="main-content">
    {{-- Section --}}
    <section class="section" style="z-index:0">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">Daftar Petunjuk Operasional Kegiatan</p>
        </div>

        {{-- Body --}}
        <div class="section-body">
            @include('components.notification.flash')

            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">

                        @if (auth()->user()->hasRole('subkoordinator') && auth()->user()->hasUnit('binagram'))
                            {{-- Card Header --}}
                            <div class="card-header">
                                <h4>
                                    <a href="{{ url(env('APP_URL') . 'kertas-kerja/unggah-pok') }}" class="btn btn-icon icon-left btn-primary text-white">
                                        <i class="fa fa-plus"></i>
                                        Unggah POK
                                    </a>
                                </h4>
                            </div>
                        @endif

                        {{-- Card Body --}}
                        <div class="card-body">
                            @if($daftarPok->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <tbody>
                                            {{-- Columns --}}
                                            <tr>
                                                <th>Keterangan</th>
                                                <th>Tanggal Unggah</th>
                                                <th>Versi Revisi</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>

                                            {{-- Content --}}
                                            @foreach ($daftarPok->paginate(10) as $pok)
                                                <tr>
                                                    <td>Petunjuk Operasional Kegiatan Tahun {{ $pok->tahun }}</td>
                                                    <td>
                                                        <i class="fa fa-calendar"></i>
                                                        <span class="ml-2">{{ DateFormat::convertDateTime($pok->created_at) }}</span>
                                                    </td>
                                                    <td>
                                                        Revisi Ke - {{ $pok->revisi }}
                                                    </td>
                                                    <td>
                                                        @if($pok->pakai)
                                                            <div class="badge badge-success">Terbaru</div>
                                                        @else
                                                            <div class="badge badge-warning">Usang</div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a
                                                            href="{{ url(env('APP_URL') . 'kertas-kerja/lihat-pok/' . $pok->tahun . '/' . $pok->revisi) }}"
                                                            class="btn btn-icon btn-info"
                                                            data-toggle="tooltip"
                                                            data-placement="bottom"
                                                            title=""
                                                            data-original-title="Lihat POK">
                                                            <i class="far fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{ $daftarPok->paginate(10)->links('vendor.pagination.bootstrap-4') }}
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
