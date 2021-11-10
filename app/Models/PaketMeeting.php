<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ipulmisaja\Macoa\Helpers\IdGenerator;

class PaketMeeting extends Model
{
    protected $table = 'paket_meeting';

    protected $fillable = [
        'reference_id',
        'user_id',
        'tanggal_pengajuan',
        'nomor_pengajuan',
        'nama',
        'pok_id',
        'total',
        'volume',
        'file',
        'catatan'
    ];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->reference_id = IdGenerator::generate([
                'table'  => 'paket_meeting',
                'field'  => 'reference_id',
                'length' => 10,
                'prefix' => 'PM-'
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

    public function scopeKepegawaian($query)
    {
        return $query
                -> where('approve_kf', 1)
                -> where('approve_binagram', 1)
                -> where('approve_ppk', 1)
                -> where('followup_kepeghum', 0)
                -> get();
    }

    public function scopeKeuangan($query)
    {
        return $query
                -> where('approve_kf', 1)
                -> where('approve_binagram', 1)
                -> where('approve_ppk', 1)
                -> where('followup_keuangan', 0)
                -> get();
    }

    public function scopeBarjas($query)
    {
        return $query
                -> where('approve_kf', 1)
                -> where('approve_binagram', 1)
                -> where('approve_ppk', 1)
                -> where('followup_barjas', 0)
                -> get();
    }
}
