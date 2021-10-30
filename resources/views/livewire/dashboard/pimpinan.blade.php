{{-- Ringkasan Pagu --}}
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary mr-4">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Pagu Anggaran</h4>
                </div>
                <div class="card-body">
                    Rp. {{ number_format($total, 0, ',', '.') }},-
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger mr-4">
                <i class="fas fa-money-check"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Realisasi Anggaran</h4>
                </div>
                <div class="card-body">
                    {{-- Rp. {{ number_format($realization, 0, ',', '.') }} --}}
                    Rp. 10.420.250.000,-
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning mr-4">
                <i class="fas fa-coins"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Sisa Anggaran</h4>
                </div>
                <div class="card-body">
                    {{-- Rp. {{ number_format($total - $realization, 0, ',', '.') }} --}}
                    Rp. 4.005.054.000,-
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Serapan Anggaran --}}
<div class="row">
    <div class="col-lg-6 col-md-6 col-12">
        <div class="card">
            <div class="card-header">
                <h4>Serapan Anggaran Menurut Fungsi</h4>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <div class="text-small float-right font-weight-bold text-muted">75,79 %</div>
                    <div class="font-weight-bold mb-1">Bagian Umum</div>
                    <div class="progress" data-height="3" style="height: 3px;">
                        <div class="progress-bar" role="progressbar" data-width="75.79%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 75.79%;"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="text-small float-right font-weight-bold text-muted">77,56 %</div>
                    <div class="font-weight-bold mb-1">Fungsi Statistik Sosial</div>
                    <div class="progress" data-height="3" style="height: 3px;">
                        <div class="progress-bar" role="progressbar" data-width="77.56%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 77.56%;"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="text-small float-right font-weight-bold text-muted">67,20 %</div>
                    <div class="font-weight-bold mb-1">Fungsi Statistik Produksi</div>
                    <div class="progress" data-height="3" style="height: 3px;">
                        <div class="progress-bar" role="progressbar" data-width="67.20%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 67.20%;"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="text-small float-right font-weight-bold text-muted">57,76 %</div>
                    <div class="font-weight-bold mb-1">Fungsi Statistik Distribusi</div>
                    <div class="progress" data-height="3" style="height: 3px;">
                        <div class="progress-bar" role="progressbar" data-width="57.76%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 57.76%;"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="text-small float-right font-weight-bold text-muted">73,29 %</div>
                    <div class="font-weight-bold mb-1">Fungsi Neraca Wilayah dan Analisis Statistik</div>
                    <div class="progress" data-height="3" style="height: 3px;">
                        <div class="progress-bar" role="progressbar" data-width="73.29%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 73.29%;"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="text-small float-right font-weight-bold text-muted">91,32 %</div>
                    <div class="font-weight-bold mb-1">Fungsi Integrasi Pengolahan dan Diseminasi Statistik</div>
                    <div class="progress" data-height="3" style="height: 3px;">
                        <div class="progress-bar" role="progressbar" data-width="91.32%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 91.32%;"></div>
                    </div>
                </div>
        </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-12">
        <div class="card">
            <div class="card-header">
                <h4>Serapan Anggaran Menurut Akun Belanja</h4>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <div class="text-small float-right font-weight-bold text-muted">75,36 %</div>
                    <div class="font-weight-bold mb-1">Belanja Pegawai (Kode 51)</div>
                    <div class="progress" data-height="3" style="height: 3px;">
                        <div class="progress-bar" role="progressbar" data-width="75.36%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 75.36%;"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="mb-1 text-white">asdas</div>
                </div>

                <div class="mb-4">
                    <div class="text-small float-right font-weight-bold text-muted">72,01 %</div>
                    <div class="font-weight-bold mb-1">Belanja Barang (Kode 52)</div>
                    <div class="progress" data-height="3" style="height: 3px;">
                        <div class="progress-bar" role="progressbar" data-width="72.01%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 72.01%;"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="mb-1 text-white">asdas</div>
                </div>

                <div class="mb-4">
                    <div class="text-small float-right font-weight-bold text-muted">85,13 %</div>
                    <div class="font-weight-bold mb-1">Belanja Modal</div>
                    <div class="progress" data-height="3" style="height: 3px;">
                        <div class="progress-bar" role="progressbar" data-width="85.13%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 85.13%;"></div>
                    </div>
                </div>

        </div>
        </div>
    </div>
</div>
