@section('title', 'Log Aplikasi')

<div class="main-content">
    {{-- Section --}}
    <section class="section" style="z-index:0">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">Log Aplikasi</p>
        </div>

        {{-- Body --}}
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">
                        {{-- Card Header --}}
                        <div class="card-header">
                            <h4>
                                <button class="btn btn-icon icon-left btn-primary">
                                    <i class="fas fa-trash"></i>
                                    <span class="ml-1">Hapus</span>
                                </button>
                            </h4>
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body p-0">

                            @if (count($logFiles) > 0)
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
                                                <th>Nama File</th>
                                                <th>Ukuran</th>
                                                <th>Waktu Pembuatan</th>
                                                <th>Aksi</th>
                                            </tr>

                                            {{-- Content --}}
                                            @forelse($logFiles as $key => $logFile)
                                                <tr>
                                                    <td class="p-0 text-center">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-1">
                                                            <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                                        </div>
                                                    </td>
                                                    <td>{{ $logFile->getFilename() }}</td>
                                                    <td>{{ number_format($logFile->getSize(), 0, ',', '.') }} KB</td>
                                                    <td>{{ date('d M Y', $logFile->getMTime()) }}</td>
                                                    <td>
                                                        <a
                                                            href="{{ route('setting.log.show', $logFile->getFilename()) }}"
                                                            class="btn btn-icon btn-info"
                                                            data-toggle="tooltip"
                                                            data-placement="bottom"
                                                            title=""
                                                            data-original-title="Lihat file {{ $logFile->getFilename() }}">
                                                                <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                @include('components.notification.not-found', [
                                                    'data_height' => 400,
                                                    'description' => "Maaf, kami tidak dapat menemukan data apapun, " .
                                                                    "untuk menghilangkan pesan ini, unggah setidaknya 1 pok."
                                                ])
                                            @endforelse
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
