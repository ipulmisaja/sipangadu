<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PangkatGolongan extends Model
{
    protected $table = 'pangkat_golongan';

    protected $fillable = ['nama'];

    public $timestamps = false;

    public function userRelation()
    {
        return $this->hasOne(User::class, 'rank_group_id', 'id');
    }
}
