<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ipulmisaja\Macoa\Helpers\IdGenerator;

class Lembur extends Model
{
    protected $table = 'lembur';

    protected $fillable = [
        'reference_id',
        'tanggal_pengajuan',
        'nomor_pengajuan',
        'nama',
        'pok_id',
        'nomor_spkl',
        'tanggal_spkl',
        'catatan'
    ];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        self::creating(function($model) {
            $model->reference_id = IdGenerator::generate([
                'table'  => 'lembur',
                'field'  => 'reference_id',
                'length' => 10,
                'prefix' => 'LB-'
            ]);
        });
    }

    public function getRouteKeyName()
    {
        return 'reference_id';
    }

    public function commentRelationship()
    {
        return $this->hasMany(Comment::class, 'proposal_id', 'reference_id');
    }

    public function pokRelationship()
    {
        return $this->hasOne(Pok::class, 'id', 'pok_id');
    }

    public function pemeriksaanRelationship()
    {
        return $this->hasOne(Pemeriksaan::class, 'reference_id', 'reference_id');
    }

    public function detailLemburRelationship()
    {
        return $this->hasMany(DetailLembur::class, 'lembur_id', 'id');
    }

    // public function scopeKeuangan($query)
    // {
    //     return $query
    //             -> where('approve_koordinator', 1)
    //             -> where('approve_bigram', 1)
    //             -> where('approve_ppk', 1)
    //             -> where('approve_kepala', 1)
    //             -> where('followup_keuangan', 0)
    //             -> get();
    // }
}
