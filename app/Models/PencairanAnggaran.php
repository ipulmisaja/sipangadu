<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PencairanAnggaran extends Model
{
    protected $table = 'pencairan_anggaran';

    protected $fillable = [
        'nama',
        'reference_id',
        'pok_id',
        'spm',
        'spm_date',
        'total',
        'volume',
        'approve_ppk',
        'tanggal_approve_ppk'
    ];

    public function userRelationship()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function pokRelationship()
    {
        return $this->hasOne(Pok::class, 'id', 'pok_id');
    }

    public function paketMeetingRelationship()
    {
        return $this->hasOne(PaketMeeting::class, 'reference_id', 'reference_id');
    }

    public function lemburRelationship()
    {
        return $this->hasOne(Lembur::class, 'reference_id', 'reference_id');
    }

    public function perjadinRelationship()
    {
        return $this->hasOne(PerjalananDinas::class, 'reference_id', 'reference_id');
    }

    public function berkasRelationship()
    {
        return $this->hasMany(Berkas::class, 'reference_id', 'reference_id');
    }

    public function scopeRealizationBudget($query)
    {
        return $query->where('approve_ppk', 1)->sum('total');
    }
}
