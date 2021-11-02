<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .text {
            font-size: 9pt
        }
        .text-title {
            font-size: 11pt
        }
    </style>
</head>
<body>
    <section>
        <center>
            <span class="font-weight-bold text-title">FORMULIR PERMINTAAN<br>PERJALANAN DINAS BIASA</span><br>
            <span class="text">Nomor: {{ $nomor }}</span>
        </center>

        <div class="content mt-4">
            <p class="text">
                Kepada Yth. <br>
                Pejabat Pembuat Komitmen BPS Prov. Sulbar <br>
                Di- <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Badan Pusat Statistik Provinsi Sulawesi Barat
            </p>
            <div class="text">
                Bersama ini disampaikan formulir permintaan Belanja Perjalanan Dinas Biasa :
            </div>
            <table>
                <tr class="text">
                    <td>2. Penyelenggara</td>
                    <td>&nbsp;&nbsp;&nbsp;:&nbsp;</td>
                    <td>Badan Pusat Statistik Provinsi Sulawesi Barat</td>
                </tr>
                <tr class="text">
                    <td>3. Bagian/Fungsi</td>
                    <td>&nbsp;&nbsp;&nbsp;:&nbsp;</td>
                    <td>{{ $fungsi }}</td>
                </tr>
                <tr class="text">
                    <td>4. Program</td>
                    <td>&nbsp;&nbsp;&nbsp;:&nbsp;</td>
                    <td>{{ $program }}</td>
                </tr>
                <tr class="text">
                    <td>5. Kegiatan</td>
                    <td>&nbsp;&nbsp;&nbsp;:&nbsp;</td>
                    <td>{{ $kegiatan }}</td>
                </tr>
                <tr class="text">
                    <td>6. Output</td>
                    <td>&nbsp;&nbsp;&nbsp;:&nbsp;</td>
                    <td>{{ $output }}</td>
                </tr>
                <tr class="text">
                    <td>7. Komponen</td>
                    <td>&nbsp;&nbsp;&nbsp;:&nbsp;</td>
                    <td>{{ $komponen }}</td>
                </tr>
                <tr class="text">
                    <td>8. Grup Akun</td>
                    <td>&nbsp;&nbsp;&nbsp;:&nbsp;</td>
                    <td>{{ $akun }}</td>
                </tr>
                <tr class="text">
                    <td>9. Item Aktivitas Dalam POK</td>
                    <td>&nbsp;&nbsp;&nbsp;:&nbsp;</td>
                    <td>{{ $detail }}</td>
                </tr>
                <tr class="text">
                    <td>10. Penggunaan Anggaran</td>
                    <td>&nbsp;&nbsp;&nbsp;:</td>
                </tr>
            </table>
            <table class="table table-bordered mt-2">
                <tr class="text">
                    <th>No.</th>
                    <th>Item Kegiatan (disesuaikan dalam POK)</th>
                    <th>Pagu POK</th>
                    <th>Realisasi Anggaran (Kumulatif)</th>
                    <th>Sisa Anggaran yang Masih Dapat Digunakan</th>
                    <th>Anggaran yang Akan Digunakan</th>
                    <th>Sisa Anggaran</th>
                </tr>
                <tr class="text">
                    <td>1</td>
                    <td>{{ strip_tags($row1col1) }}</td>
                    <td>{{ number_format($row1col2, 0, ',', '.') }}</td>
                    <td>-</td>
                    <td>{{ number_format($row1col4, 0, ',', '.') }}</td>
                    <td>{{ number_format($row1col5, 0, ',', '.') }}</td>
                    <td>{{ number_format($row1col6, 0, ',', '.') }}</td>
                </tr>
                <tr class="text">
                    <td colspan="2" class="text-center">Jumlah</td>
                    <td>{{ number_format($row2col2, 0, ',', '.') }}</td>
                    <td>-</td>
                    <td>{{ number_format($row2col4, 0, ',', '.') }}</td>
                    <td>{{ number_format($row2col5, 0, ',', '.') }}</td>
                    <td>{{ number_format($row2col6, 0, ',', '.') }}</td>
                </tr>
            </table>
            <table>
                <tr class="text">
                    <td>11. Daftar Peserta Perjalanan Dinas Sebagai Berikut :</td>
                </tr>
            </table>
            <table class="table table-bordered mt-2">
                <tr class="text">
                    <th>No.</th>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Jabatan</th>
                    <th>Tanggal</th>
                    <th>Lamanya (O-H)</th>
                    <th>Tujuan</th>
                </tr>
                @foreach ($user_trip as $index => $item)
                    @php
                        $user = \App\Models\User::where('id', $item->user_id)->get();
                    @endphp
                    <tr class="text">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user[0]->nama }}</td>
                        <td>{{ $user[0]->nip_id }}</td>
                        <td>{{ $user[0]->pangkatGolonganRelationship->nama }}</td>
                        <td>{{ DateFormat::convertDateTime($item->tanggal_berangkat) . ' s/d ' . DateFormat::convertDateTime($item->tanggal_kembali) }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_kembali, 'UTC')->diffInDays(\Carbon\Carbon::parse($item->tanggal_berangkat, 'UTC')) + 1 }}</td>
                        <td>{{ $item->tujuan }}</td>
                    </tr>
                @endforeach
            </table>
        </div>

        <table class="mt-4" style="table-layout:fixed; width:100%">
            <tr>
                <td>
                    <center class="text mb-4">
                        <span></span><br>
                        <span>Kepala</span><br>
                        <span>BPS Provinsi Sulawesi Barat</span><br><br>
                        @if ($kpa == 1)
                            <img src="{{ public_path('template/kabps_ttd.png') }}" width="125"><br>
                        @else
                            <br>
                        @endif
                        <span class="font-weight-bold">{{ $kpa_boss->nama }}</span><br>
                        <span>NIP. {{ $kpa_boss->nip_id }}</span>
                    </center>
                </td>
                <td></td>
                <td>
                    <center class="text mb-4">
                        <span>Mamuju, {{ DateFormat::convertDateTime($tanggal_pengajuan) }}</span><br>
                        <span>
                            @if ($nama_unit_koordinator === 'Tata Usaha')
                                Kepala Bagian Umum
                            @else
                                Koordinator Fungsi {{ $nama_unit_koordinator }}
                            @endif
                        </span><br><br>
                        @if ($koordinator == 1)
                            @switch($nama_unit_koordinator_boss->nama)
                                @case("Markus Uda")
                                    <img src="{{ public_path('template/markus_uda.png') }}" width="125"><br>
                                    @break
                                @case("Heni Djumadi")
                                    <img src="{{ public_path('template/heni_djumadi.png') }}" width="125"><br>
                                    @break
                                @case("Muhammad Nurbakti")
                                    <img src="{{ public_path('template/muhammad_nurbakti.png') }}" width="125"><br>
                                    @break
                                @case("Fredy Takaya")
                                    <img src="{{ public_path('template/fredy_takaya.png') }}" width="125"><br>
                                    @break
                                @case("M. La'bi")
                                    <img src="{{ public_path('template/labi.png') }}" width="125"><br>
                                    @break
                                @case("Prayitno")
                                    <img src="{{ public_path('template/prayitno.png') }}" width="125"><br>
                                    @break
                            @endswitch
                        @else
                            <br>
                        @endif
                        <span class="font-weight-bold">{{ $nama_unit_koordinator_boss->nama }}</span><br>
                        <span>NIP. {{ $nama_unit_koordinator_boss->nip_id }}</span>
                    </center>
                </td>
            </tr>
            <tr>
                <td>
                    {{-- <div class="text ml-4 mb-4">
                        <span class="font-weight-bold">Tembusan Yth:</span><br>
                        <span>1. Kuasa Pengguna Anggaran</span><br>
                        <span>2. Kepala Bagian Tata Usaha</span><br>
                        <span>3. Panitia/Pejabat Pengadaan</span>
                    </div> --}}
                </td>
                <td></td>
                <td>
                    <center class="text">
                        <span>Mengetahui,</span><br>
                        <span>Pejabat Pembuat Komitmen</span><br><br>
                        @if ($ppk == 1)
                            <img src="{{ public_path('template/ttd.jpg') }}" width="125"><br>
                        @else
                            <br>
                        @endif
                        <span class="font-weight-bold">{{ $ppk_boss->nama }}</span><br>
                        <span>NIP. {{ $ppk_boss->nip_id }}</span>
                    </center>
                </td>
            </tr>
        </table>
    </section>
</body>
</html>
