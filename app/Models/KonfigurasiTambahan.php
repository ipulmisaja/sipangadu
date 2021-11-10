<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KonfigurasiTambahan extends Model
{
    protected $table = 'konfigurasi_tambahan';

    protected $fillable = [
        'user_id',
        'status',
        'tanggal_tutup'
    ];

    public $timestamps = false;
}
