<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleRepository
{
    public function save($case, Request $request, $model = null)
    {
        switch($case) {
            case 'store':
                Role::create([
                    'name'        => $request->role,
                    'description' => $request->description
                ]);
                break;
            case 'update':
                $model->update([
                    'name'        => $request->role,
                    'description' => $request->description
                ]);
                break;
        }
    }
}
