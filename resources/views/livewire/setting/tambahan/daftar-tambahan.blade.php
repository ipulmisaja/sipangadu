@section('title', 'Daftar Konfigurasi Tambahan')

<div class="main-content">
    <section class="section" style="z-index:0">
        <div class="section-header">
            <p class="h3">Daftar Konfigurasi Tambahan</p>
        </div>
        <div class="section-body">
            @include('components.notification.flash')

            {{-- Konfigurasi POK, Tanggal Pengajuan dan Approval --}}
            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">
                        <div class="card-header bg-light">
                            <span class="w-100" style="font-size:1rem">Konfigurasi POK, Tanggal Pengajuan, dan Approval</span>
                            <a href="{{ url(env('APP_URL') . 'setting/tambahan/konfigurasi-baru') }}" class="btn btn-icon icon-left btn-primary">
                                <i class="fas fa-plus"></i> Tambah Konfigurasi
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    @if ($konfigurasiTambahan->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <tbody>
                                                    <tr>Nomor Pengajuan</tr>
                                                    <tr>Konfigurasi Pilih POK</tr>
                                                    <tr>Konfigurasi Tanggal Pengajuan & Approval</tr>
                                                </tbody>

                                                @foreach ($konfigurasiTambahan->paginate(20) as $item)
                                                    <tr>

                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    @else
                                        @include('components.notification.not-found', [
                                            'data_height' => 200,
                                            'description' => "Maaf, kami tidak dapat menemukan data apa pun, " .
                                                                "silahkan tambah konfigurasi baru."
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
