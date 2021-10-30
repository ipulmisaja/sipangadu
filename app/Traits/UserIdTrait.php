<?php

namespace App\Traits;

use App\Models\Unit;
use App\Models\User;

trait UserIdTrait
{
    /**
     * Get User ID From Specific Role
     *
     * @param string $role
     * @return int id
     */
    public function getUserIdByRole(string $role) : ?int
    {
        return User::query()
            -> whereHas("roles", function($q) use ($role) { $q->where('name', $role); })
            -> first('id')
            -> id;
    }

    public function getUserIdByUnit(string $unit, string $role = 'subkoordinator') : ?int
    {
        $unitId = Unit::where('slug', $unit)->first('id')->id;

        return User::query()
            -> where('unit_id', $unitId)
            -> whereHas('roles', function($q) use ($role) { $q->where('name', $role); })
            -> first('id')
            -> id;
    }
}
