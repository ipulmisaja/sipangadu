<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $table = 'komentar';

    protected $fillable = [
        'reference_id',
        'komentator_id',
        'komentator_tipe',
        'status',
        'deskripsi',
        'tanggal_komentar'
    ];

    public $timestamps = false;

    public function userRelationship()
    {
        return $this->hasOne(User::class, 'id', 'komentator_id');
    }
}
