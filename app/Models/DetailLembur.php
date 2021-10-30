<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailLembur extends Model
{
    protected $table = 'detail_lembur';

    protected $fillable = [
        'lembur_id',
        'user_id',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_berakhir',
        'durasi'
    ];

    public $timestamps = false;

    public function lemburRelationship()
    {
        return $this->belongsTo(Lembur::class, 'id', 'lembur_id');
    }
}
