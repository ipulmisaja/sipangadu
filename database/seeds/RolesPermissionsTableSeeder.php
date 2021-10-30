<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'admin', 'description' => 'Administrator Aplikasi']);
        Role::create(['name' => 'kpa', 'description' => 'Kuasa Pengguna Anggaran']);
        Role::create(['name' => 'ppk', 'description' => 'Pejabat Pembuat Komitmen']);
        Role::create(['name' => 'koordinator', 'description' => 'Koordinator Kegiatan/Kepala Bagian']);
        Role::create(['name' => 'subkoordinator' , 'description' => 'Subkoordinator Kegiatan']);
        Role::create(['name' => 'binagram', 'description' => 'Fungsi Perencanaan Anggaran']);
        Role::create(['name' => 'staf', 'description' => 'Staf Unit Kerja']);
        Role::create(['name' => 'sekretaris', 'description' => 'Sekretaris Kepala BPS']);

        Permission::create(['name' => 'unggah pok']);
        Permission::create(['name' => 'cek usul koordinator']);
        Permission::create(['name' => 'cek usul binagram']);
        Permission::create(['name' => 'cek usul ppk']);
    }
}
