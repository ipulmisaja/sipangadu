<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPerjalananDinas extends Model
{
    protected $table = 'detail_perjalanan_dinas';

    protected $fillable = [
        'perjadin_id',
        'reference_id',
        'user_id',
        'tujuan',
        'tanggal_berangkat',
        'tanggal_kembali',
        'catatan',
        'mail_number'
    ];

    public $timestamps = false;

    public function perjalananDinasRelationship()
    {
        return $this->belongsTo(PerjalananDinas::class, 'perjadin_id', 'id');
    }

    public function userRelationship()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
