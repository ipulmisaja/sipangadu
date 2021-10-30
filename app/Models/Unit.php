<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'unit';

    protected $fillable = ['nama', 'slug', 'parent'];

    public $timestamps = false;

    public function getRouteKey()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function poks()
    {
        return $this->hasMany(Pok::class, 'id', 'unit_id');
    }

    public static function getChild($unitId)
    {
        $jabatan = Unit::where('parent', $unitId)->get('id');

        $value = [];

        foreach($jabatan as $item) array_push($value, $item->id);

        return $value;
    }

    public static function getChildUser($unitId)
    {
        $unit = Unit::where('parent', $unitId)->get('id');

        $user = User::whereIn('unit_id', $unit)->get('id');

        $value = [];

        foreach($user as $item) array_push($value, $item->id);

        return $value;
    }
}
