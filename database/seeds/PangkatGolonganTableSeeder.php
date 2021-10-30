<?php

use App\Models\PangkatGolongan;
use Illuminate\Database\Seeder;

class PangkatGolonganTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PangkatGolongan::create(['nama' => 'Juru Muda (I/a)']);
        PangkatGolongan::create(['nama' => 'Juru Muda Tk. I (I/b)']);
        PangkatGolongan::create(['nama' => 'Juru (I/c)']);
        PangkatGolongan::create(['nama' => 'Juru Tk. I (I/d)']);
        PangkatGolongan::create(['nama' => 'Pengatur Muda (II/a)']);
        PangkatGolongan::create(['nama' => 'Pengatur Muda Tk. I (II/b)']);
        PangkatGolongan::create(['nama' => 'Pengatur (II/c)']);
        PangkatGolongan::create(['nama' => 'Pengatur Tk. I (II/d)']);
        PangkatGolongan::create(['nama' => 'Penata Muda (III/a)']);
        PangkatGolongan::create(['nama' => 'Penata Muda Tk. I (III/b)']);
        PangkatGolongan::create(['nama' => 'Penata (III/c)']);
        PangkatGolongan::create(['nama' => 'Penata Tk. I (III/d)']);
        PangkatGolongan::create(['nama' => 'Pembina (IV/a)']);
        PangkatGolongan::create(['nama' => 'Pembina Tk. I (IV/b)']);
        PangkatGolongan::create(['nama' => 'Pembina Utama Muda (IV/c)']);
        PangkatGolongan::create(['nama' => 'Pembina Utama Madya (IV/d)']);
        PangkatGolongan::create(['nama' => 'Pembina Utama (IV/e)']);
    }
}
