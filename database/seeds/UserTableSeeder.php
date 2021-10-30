<?php

use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Hapus isi tabel users
        DB::table('user')->truncate();

        $json = File::get('database/data/user7600.json');
        $data = json_decode($json);

        foreach ($data as $user) {
            if ($user->bps_id === '340056465') {
                $temp = User::create([
                    'nama'                => $user->nama,
                    'username'            => explode('@', $user->email)[0],
                    'password'            => bcrypt($user->password),
                    'slug'                => Str::slug($user->nama),
                    'email'               => $user->email,
                    'bps_id'              => $user->bps_id,
                    'nip_id'              => $user->nip_id,
                    'pangkat_golongan_id' => $user->pangkat_golongan,
                    'unit_id'             => 26
                ]);
            } else {
                $temp = User::create([
                    'nama'                => $user->nama,
                    'username'            => explode('@', $user->email)[0],
                    'password'            => bcrypt($user->password),
                    'slug'                => Str::slug($user->nama),
                    'email'               => $user->email,
                    'bps_id'              => $user->bps_id,
                    'nip_id'              => $user->nip_id,
                    'pangkat_golongan_id' => $user->pangkat_golongan,
                    'unit_id'             => $user->unit,
                ]);
            }

            $temp->assignRole($user->role);
        }
    }
}
