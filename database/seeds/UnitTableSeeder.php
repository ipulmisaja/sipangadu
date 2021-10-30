<?php

use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unit::create([
            'nama'   => 'Kepala BPS',
            'slug'   => Str::slug('kepala bps'),
            'parent' => 0
        ]);

        Unit::create([
            'nama'   => 'Tata Usaha',
            'slug'   => Str::slug('tu'),
            'parent' => 1
        ]);

        Unit::create([
            'nama'   => 'Statistik Sosial',
            'slug'   => Str::slug('statistik sosial'),
            'parent' => 1
        ]);

        Unit::create([
            'nama'   => 'Statistik Produksi',
            'slug'   => Str::slug('statistik produksi'),
            'parent' => 1
        ]);

        Unit::create([
            'nama'   => 'Statistik Distribusi',
            'slug'   => Str::slug('statistik distribusi'),
            'parent' => 1
        ]);

        Unit::create([
            'nama'   => 'Nerwilis',
            'slug'   => Str::slug('nerwilis'),
            'parent' => 1
        ]);

        Unit::create([
            'nama'   => 'IPDS',
            'slug'   => Str::slug('ipds'),
            'parent' => 1
        ]);

        Unit::create([
            'nama'   => 'Perencana',
            'slug'   => Str::slug('binagram'),
            'parent' => 2
        ]);

        Unit::create([
            'nama'   => 'Kepegawaian dan Hukum',
            'slug'   => Str::slug('kepeghum'),
            'parent' => 2
        ]);

        Unit::create([
            'nama'   => 'Keuangan',
            'slug'   => Str::slug('keuangan'),
            'parent' => 2
        ]);

        Unit::create([
            'nama'   => 'Umum',
            'slug'   => Str::slug('umum'),
            'parent' => 2
        ]);

        Unit::create([
            'nama'   => 'Pengadaan Barang/Jasa',
            'slug'   => Str::slug('pengadaan barjas'),
            'parent' => 2
        ]);

        Unit::create([
            'nama'   => 'Statistik Kependudukan',
            'slug'   => Str::slug('statistik kependudukan'),
            'parent' => 3
        ]);

        Unit::create([
            'nama'   => 'Statistik Ketahanan Sosial',
            'slug'   => Str::slug('statistik hansos'),
            'parent' => 3
        ]);

        Unit::create([
            'nama'   => 'Statistik Kesejahteraan Rakyat',
            'slug'   => Str::slug('statistik kesra'),
            'parent' => 3
        ]);

        Unit::create([
            'nama'   => 'Statistik Pertanian',
            'slug'   => Str::slug('statistik pertanian'),
            'parent' => 4
        ]);

        Unit::create([
            'nama'   => 'Statistik Industri',
            'slug'   => Str::slug('statistik industri'),
            'parent' => 4
        ]);

        Unit::create([
            'nama'   => 'Statistik Pertambangan, Energi, Konstruksi',
            'slug'   => Str::slug('statistik pek'),
            'parent' => 4
        ]);

        Unit::create([
            'nama'   => 'Statistik HK dan HPB',
            'slug'   => Str::slug('statistik hkhpb'),
            'parent' => 5
        ]);

        Unit::create([
            'nama'   => 'Statistik Keuangan dan Harga Produsen',
            'slug'   => Str::slug('statistik khp'),
            'parent' => 5
        ]);

        Unit::create([
            'nama'   => 'Statistik Niaga dan Jasa',
            'slug'   => Str::slug('statistik ninja'),
            'parent' => 5
        ]);

        Unit::create([
            'nama'   => 'Neraca Produksi',
            'slug'   => Str::slug('nerpro'),
            'parent' => 6
        ]);

        Unit::create([
            'nama'   => 'Neraca Konsumsi',
            'slug'   => Str::slug('nerkon'),
            'parent' => 6
        ]);

        Unit::create([
            'nama'   => 'Analisis Statistik Lintas Sektor',
            'slug'   => Str::slug('asls'),
            'parent' => 6
        ]);

        Unit::create([
            'nama'   => 'Integrasi Pengolahan Data',
            'slug'   => Str::slug('ipd'),
            'parent' => 7
        ]);

        Unit::create([
            'nama'   => 'Jaringan Rujukan Statistik',
            'slug'   => Str::slug('jrs'),
            'parent' => 7
        ]);

        Unit::create([
            'nama'   => 'Diseminasi Layanan Statistik',
            'slug'   => Str::slug('dls'),
            'parent' => 7
        ]);
    }
}
