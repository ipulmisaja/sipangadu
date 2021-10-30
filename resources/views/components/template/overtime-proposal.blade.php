<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .page-break { page-break-after: always; }
        .overtime-text { font-size: 9pt }
    </style>
</head>
<body>
    <section>
        <img src="{{ public_path('images/logo2.png') }}" width="320" class="mb-4 pb-4">

        <center class="mt-4">
            <span class="h5"><u>SURAT PERINTAH KERJA LEMBUR</u></span><br>
            <span>No. {{ $nomor_spkl }}</span>
        </center>
        <div class="content mt-4 mx-4">
            <p style="text-indent:5%;line-height:1.5">
                Sehubungan dengan pelaksanaan {{ strip_tags($deskripsi) }}, maka dengan ini disampaikan hal-hal sebagai berikut:
            </p>
            <ol>
                <li>Bahwa terkait hal di atas dipandang perlu melakukan penyelesaian kegiatan tersebut.</li>
                <li>Terkait dengan butir 1 diatas dipandang perlu untuk segera melakukan penyelesaian pekerjaan di luar jam kerja/lembur.</li>
                <li>Merujuk pada DIPA/POK BPS Provinsi Sulawesi Barat, masih terdapat anggaran terkait untuk pembiayaan kegiatan tersebut, untuk itu agar dilaksanakan sesuai ketentuan yang berlaku.</li>
            </ol>
            <p style="text-indent:5%;line-height:1.5">
                Dengan adanya kegiatan lembur yang dimaksud pada point 2 di atas, dengan ini diperintahkan kepada pegawai
                seperti terlampir untuk menyelesaikan pekerjaan pada point 1 selama hari yang diperlukan pada {{ explode(' ', DateFormat::convertDateTime($tanggal_nodis))[1] . ' ' . explode(' ', DateFormat::convertDateTime($tanggal_nodis))[2] }}.
            </p>
        </div>
        <table class="mt-4" style="table-layout:fixed; width:100%">
            <tr>
                <td></td>
                <td>
                    <center class="text mb-4 pt-2">
                        <span>Ditetapkan di Mamuju</span><br>
                        <span>
                            Pada Tanggal
                            {{
                                is_null($tanggal_spkl)
                                    ? '-'
                                    : DateFormat::convertDateTime($tanggal_spkl)
                            }}
                        </span><br>
                        <span>Kepala Badan Pusat Statistik</span><br>
                        <span>Provinsi Sulawesi Barat</span><br><br><br>
                        @if ($kepala_approve == 1)
                            <img src="{{ public_path('template/ttd.jpg') }}" width="125"><br>
                        @else
                            <br>
                        @endif
                        <span class="font-weight-bold h6"><u>{{ $kepala_boss->nama }}</u></span><br>
                        <span>NIP. {{ $kepala_boss->nip_id }}</span>
                    </center>
                </td>
            </tr>
        </table>
    </section>

    <div class="page-break"></div>

    <section>
        <center class="mt-4">
            <span class="font-weight-bold"><u>NOTA DINAS</u></span><br>
            <span>Nomor : {{ $nomor_nodis }}</span>
        </center>

        <div class="content mt-4">
            <table>
                <tr>
                    <td>Kepada Yth</td>
                    <td style="width: 1%">&nbsp;:</td>
                    <td class="pl-3">&nbsp;Kuasa Pengguna Anggaran</td>
                </tr>
                <tr>
                    <td>Dari</td>
                    <td style="width: 1%">&nbsp;:</td>
                    <td class="pl-3">&nbsp;Koordinator Fungsi</td>
                </tr>
                <tr>
                    <td>Perihal</td>
                    <td style="width: 1%">&nbsp;:</td>
                    <td class="pl-3">&nbsp;Rencana Pelaksanaan Lembur</td>
                </tr>
                <tr>
                    <td>Lampiran</td>
                    <td style="width: 1%">&nbsp;:</td>
                    <td class="pl-3">&nbsp;1 Lampiran</td>
                </tr>
                <tr>
                    <td style="width: 30%" valign="top">Dasar Pelaksanaan Lembur</td>
                    <td style="width: 1%" valign="top">&nbsp;:</td>
                    <td class="pl-3" valign="top">&nbsp;{{ strip_tags($dasar_pelaksanaan) }}</td>
                </tr>
            </table>
        </div>

        <div class="detail mt-3">
            <span>Berikut ini kami sampaikan rencana pelaksanaan lembur sebagai berikut:</span>
            <table class="table table-bordered mt-2">
                <tr>
                    <th rowspan="2" class="overtime-text text-center">No.</th>
                    <th rowspan="2" class="overtime-text text-center">Nama Pegawai</th>
                    <th rowspan="2" class="overtime-text text-center">Uraian Pekerjaan</th>
                    <th rowspan="2" class="overtime-text text-center">Tanggal Pelaksanaan</th>
                    <th colspan="3" class="overtime-text text-center">Estimasi Waktu Pelaksanaan</th>
                </tr>
                <tr>
                    <th class="overtime-text text-center">Mulai Jam</th>
                    <th class="overtime-text text-center">Selesai Jam</th>
                    <th class="overtime-text text-center">Total (Jam)</th>
                </tr>
                @foreach ($user_overtime as $index => $overtime)
                    <tr>
                        <td class="overtime-text text-center">{{ $index + 1 }}</td>
                        <td class="overtime-text">{{ \App\Models\User::where('id', $overtime->user_id)->first('nama')->nama }}</td>
                        <td class="overtime-text">{{ $overtime->deskripsi }}</td>
                        <td class="overtime-text text-center">{{ DateFormat::convertDateTime($overtime->tanggal_mulai) }}</td>
                        <td class="overtime-text text-center">{{ \Carbon\Carbon::parse($overtime->tanggal_mulai)->toTimeString() }}</td>
                        <td class="overtime-text text-center">{{ \Carbon\Carbon::parse($overtime->tanggal_berakhir)->toTimeString() }}</td>
                        <td class="overtime-text text-center">{{ $overtime->durasi }} Jam</td>
                    </tr>
                @endforeach
            </table>
            <span>Demikian atas perhatian dan kerja samanya kami ucapkan terima kasih.</span>
        </div>

        <table class="mt-4" style="table-layout:fixed; width:100%">
            <tr>
                <td></td>
                <td></td>
                <td>
                    <center class="text mb-4">
                        <span>Mamuju, {{ DateFormat::convertDateTime($tanggal_nodis) }}</span><br>
                        <span>
                            @if ($kf_unit->nama === 'Tata Usaha')
                                Kepala Bagian {{ $kf_unit->nama }}
                            @else
                                Koordinator Fungsi {{ $kf_unit->nama }}
                            @endif
                        </span><br>
                        @if ($kf_approve == 1)
                            <img src="{{ public_path('template/ttd.jpg') }}" width="125"><br>
                        @else
                            <br><br>
                        @endif
                        <span class="font-weight-bold"><u>{{ $kf_boss->nama }}</u></span><br>
                        <span>NIP. {{ $kf_boss->nip_id }}</span>
                    </center>
                </td>
            </tr>
            <tr>
                <td class="pt-4 pl-4">Disetujui Oleh :</td>
            </tr>
            <tr>
                <td>
                    <center class="text mb-4">
                        <span>Pejabat Pembuat Komitmen</span><br>
                        <span>BPS Provinsi Sulawesi Barat</span><br>
                        @if ($ppk_approve == 1)
                            <img src="{{ public_path('template/ttd.jpg') }}" width="125"><br>
                        @else
                            <br><br>
                        @endif
                        <span class="font-weight-bold"><u>{{ $ppk_boss->nama }}</u></span><br>
                        <span>NIP. {{ $ppk_boss->nip_id }}</span>
                    </center>
                </td>
                <td style="width:10%"></td>
                <td>
                    <center class="text mb-4">
                        <span>Kuasa Pengguna Anggaran</span><br>
                        <span>BPS Provinsi Sulawesi Barat</span><br>
                        @if ($kepala_approve == 1)
                            <img src="{{ public_path('template/ttd.jpg') }}" width="125"><br>
                        @else
                            <br><br>
                        @endif
                        <span class="font-weight-bold"><u>{{ $kepala_boss->nama }}</u></span><br>
                        <span>NIP. {{ $kepala_boss->nip_id }}</span>
                    </center>
                </td>
            </tr>
        </table>
    </section>
</body>
</html>
