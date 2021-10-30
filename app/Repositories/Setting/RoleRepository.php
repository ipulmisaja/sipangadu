<?php

namespace App\Repositories\Setting;

use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleRepository
{
    public function store($data) : string
    {
        try {
            DB::beginTransaction();

            Role::create([
                'name'        => $data->name,
                'description' => $data->description
            ]);

            $message = 'Informasi telah disimpan.';

            DB::commit();
        } catch (Exception $error) {
            DB::rollBack();

            $message = 'Informasi gagal disimpan.';
        }

        return $message;
    }

    public function update($data) : string
    {
        try {
            DB::beginTransaction();

            $data->role->update([
                'name'        => $data->name,
                'description' => $data->description
            ]);

            $message = 'Informasi telah diperbaharui.';

            DB::commit();
        } catch(Exception $error) {
            DB::rollBack();

            $message = 'Informasi gagal diperbaharui.';
        }

        return $message;
    }
}
