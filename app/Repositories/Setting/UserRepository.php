<?php

namespace App\Repositories\Setting;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserRepository
{
    public function store($data) : string
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'name'            => $data->name,
                'username'        => explode('@', $data->email)[0],
                'slug'            => Str::slug(explode('@', $data->email)[0]),
                'email'           => $data->email,
                'password'        => bcrypt($data->password),
                'bps_id'          => $data->bpsId,
                'nip_id'          => $data->staffId,
                'rank_group_id'   => $data->rank_group,
                'unit_id'         => $data->unit,
                'password_change' => false
            ]);

            foreach($data->roleArray as $role) {
                $user->assignRole($role);
            }

            $message = "Informasi user telah disimpan.";

            DB::commit();
        } catch (Exception $error) {
            DB::rollBack();

            Log::alert($error->getMessage());

            $message = "Informasi user gagal disimpan.";
        }

        return $message;
    }

    public function update($data) : string
    {
        try {
            DB::beginTransaction();

            $data->user->update([
                'name'       => $data->name,
                'username'   => explode('@', $data->email)[0],
                'slug'       => Str::slug(explode('@', $data->email)[0]),
                'email'      => $data->email,
                'bps_id'     => $data->bpsId,
                'nip_id'     => $data->staffId
            ]);

            is_null($data->password) ?: $data->user->update(['password' => bcrypt($data->password)]);

            is_null($data->rank_group) ?: $data->user->update(['rank_group_id' => $data->rank_group]);

            is_null($data->unit) ?: $data->user->update(['unit_id' => $data->unit]);

            $data->user->syncRoles($data->roleArray);

            $message = "Informasi user telah diperbaharui.";

            DB::commit();
        } catch (Exception $error) {
            DB::rollBack();

            Log::alert($error->getMessage());

            $message = "Informasi gagal disimpan.";
        }

        return $message;
    }

    public function gantiPassword(User $user, $data) : string
    {
        try {
            DB::beginTransaction();

            $user->update([
                'password'      => bcrypt($data->password),
                'ubah_password' => true
            ]);

            $message = "Terima kasih, kata sandi anda telah diperbaharui.";

            DB::commit();
        } catch(Exception $error) {
            DB::rollBack();

            Log::alert($error->getMessage());

            $message = "Maaf, kata sandi anda gagal diperbaharui, mohon diperiksa kembali.";
        }

        return $message;
    }

    public function resetPassword()
    {}
}
