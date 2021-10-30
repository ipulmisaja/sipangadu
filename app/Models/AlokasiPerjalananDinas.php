<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlokasiPerjalananDinas extends Model
{
    protected $table = 'alokasi_perjalanan_dinas';

    protected $fillable = [
        'tahun',
        'pok_id',
        'user_id',
        'total'
    ];

    public $timestamps = false;

    public function userRelationship()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function pokRelationship()
    {
        return $this->belongsTo(Pok::class, 'pok_id', 'id');
    }
}
