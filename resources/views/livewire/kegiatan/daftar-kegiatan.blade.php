@section('title', 'Daftar Pengajuan Kegiatan')

<div class="main-content">
    {{-- Section --}}
    <section class="section" style="z-index:0">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">Daftar Pengajuan Kegiatan</p>
        </div>

        {{-- Body --}}
        <div class="section-body">
            {{-- Notification --}}
            @include('components.notification.flash')

            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">
                        <div class="card-header">
                            <h4>
                                <div class="dropdown d-inline mr-2">
                                    <button class="btn btn-icon icon-left btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-plus"></i>
                                        <span class="ml-1">Buat Pengajuan Kegiatan Baru</span>
                                    </button>
                                    <div class="dropdown-menu border w-100" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <a class="mt-1 dropdown-item" href="{{ url(env('APP_URL') . 'kegiatan/paket-meeting/buat') }}">
                                            Paket Meeting
                                        </a>
                                        <a class="mt-1 dropdown-item" href="{{ url(env('APP_URL') . 'kegiatan/lembur/buat') }}">
                                            Lembur
                                        </a>
                                        <a class="mt-1 dropdown-item" href="{{ url(env('APP_URL') . 'kegiatan/perjalanan-dinas/buat') }}">
                                            Perjalanan Dinas
                                        </a>
                                    </div>
                                </div>
                            </h4>
                            <div class="card-header-form">
                                <select class="form-control">
                                    <option value>- Seluruh Pengajuan Kegiatan -</option>
                                    <option value="FB">Paket Meeting</option>
                                    <option value="LB">Lembur</option>
                                    <option value="PD">Perjalanan Dinas</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    @if ($listActivity->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <tbody>
                                                    {{-- Columns --}}
                                                    <tr>
                                                        <th>Jenis Kegiatan</th>
                                                        <th>Nama Kegiatan</th>
                                                        <th>Kode dan Deskripsi Anggaran</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>

                                                    {{-- Content --}}
                                                    @foreach ($listActivity->paginate(20) as $item)
                                                        @php
                                                            $relationship = getModelRelationship($item->proposal_id)['relationship']
                                                        @endphp
                                                        <tr class="my-3">
                                                            <td>
                                                                <span class="badge {{ getModelRelationship($item->proposal_id)['badge'] }}">
                                                                    {{ getModelRelationship($item->proposal_id)['name'] }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted font-weight-bold">
                                                                    <i class="fa fa-calendar"></i>
                                                                    <span class="ml-2">
                                                                        {{ DateFormat::convertDateTime($item->tanggal_proposal) }}
                                                                    </span>
                                                                </span><br>
                                                                <span>{{ $item->$relationship->name }}</span>
                                                                </td>
                                                            <td>
                                                                <span class="text-muted font-weight-bold">
                                                                    <i class="fas fa-coins"></i>
                                                                    <span class="ml-1">
                                                                        {{
                                                                            '054.01.' .
                                                                            $item->$relationship->pokRelationship->kd_program . '.' .
                                                                            $item->$relationship->pokRelationship->kd_kegiatan . '.' .
                                                                            $item->$relationship->pokRelationship->kd_kro . '.' .
                                                                            $item->$relationship->pokRelationship->kd_ro . '.' .
                                                                            $item->$relationship->pokRelationship->kd_komponen . '.' .
                                                                            $item->$relationship->pokRelationship->kd_subkomponen . '.' .
                                                                            $item->$relationship->pokRelationship->kd_akun . '.' .
                                                                            $item->$relationship->pokRelationship->kd_detail
                                                                        }}
                                                                    </span>
                                                                </span><br>
                                                                <span>{{ $item->$relationship->pokRelationship->deskripsi }}</span>
                                                            </td>
                                                            <td>
                                                                @include('components.state.approval', [
                                                                    'model' => $item,
                                                                    'stage' => getModelRelationship($item->proposal_id)['alias']
                                                                ])
                                                            </td>
                                                            <td>
                                                                <a
                                                                    href="{{ url(env('APP_URL') . 'kegiatan/' . getModelRelationship($item->proposal_id)['url'] . '/' . $item->proposal_id . '/detail') }}"
                                                                    type="button"
                                                                    class="btn btn-icon btn-info"
                                                                    data-toggle="tooltip"
                                                                    data-placement="bottom"
                                                                    title=""
                                                                    data-original-title="Lihat">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                                @if($item->coordinator_approve === 0)
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
                                            {{ $listActivity->paginate(20)->links('vendor.pagination.sipangadu') }}
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

@push('scripts')
<script>
    $(document).ready(function() {
        $('span#fullboard-badge').addClass('badge-white');
        $('span#lembur-badge').addClass('badge-primary');
        $('span#perjadin-badge').addClass('badge-primary');

        $('a#fullboard-tab').click(function() {
            $('span#fullboard-badge').addClass('badge-white');
            $('span#lembur-badge').removeClass('badge-white');
            $('span#perjadin-badge').removeClass('badge-white');
        });

        $('a#lembur-tab').click(function() {
            $('span#fullboard-badge').removeClass('badge-white').addClass('badge-primary');
            $('span#lembur-badge').addClass('badge-white');
            $('span#perjadin-badge').removeClass('badge-white');
        });

        $('a#perjadin-tab').click(function() {
            $('span#fullboard-badge').removeClass('badge-white').addClass('badge-primary');
            $('span#lembur-badge').removeClass('badge-white');
            $('span#perjadin-badge').addClass('badge-white');
        });
    });
</script>
@endpush
