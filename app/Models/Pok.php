<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pok extends Model
{
    protected $table = 'pok';

    protected $fillable = [
        'tahun',
        'revisi',
        'pakai',
        'kd_departemen',
        'kd_organisasi',
        'kd_program',
        'kd_kegiatan',
        'kd_kro',
        'kd_ro',
        'kd_komponen',
        'kd_subkomponen',
        'kd_akun',
        'kd_detail',
        'deskripsi',
        'volume',
        'satuan',
        'harga_satuan',
        'total',
        'unit_id',
        'volume_realisasi',
        'total_realisasi'
    ];

    public $timestamps = false;

    public function getRouteKeyName()
    {
        return 'tahun';
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function scopeActivityList($query, $operator, $activity)
    {
        return $query
                -> where('pakai', true)
                -> where('kd_kegiatan', $operator, $activity)
                -> where('kd_kro', '000')
                -> where('kd_ro', '000')
                -> get();
    }

    public function scopeOutputList($query, $operator, $activity)
    {
        return $query
               -> where('pakai', true)
               -> where('kd_kegiatan', $operator, $activity)
               -> where('kd_kro', '<>', '000')
               -> where('kd_ro', '<>', '000')
               -> where('kd_komponen', '000')
               -> get();
    }

    public function scopeComponentList($query, ...$params)
    {
        return $query
               -> where('pakai', true)
               -> where('kd_kegiatan', $params[0])
               -> where('kd_kro', '<>', '000')
               -> where('kd_ro', $params[1])
               -> where('kd_komponen', '<>', '000')
               -> where('kd_subkomponen', '0')
               -> get();
    }

    public function scopeDetailList($query, ...$params)
    {
        return $query
               -> where('pakai', true)
               -> where('kd_kegiatan', $params[0])
               -> where('kd_kro', '<>', '000')
               -> where('kd_ro', $params[1])
               -> where('kd_komponen', '<>', '000')
               -> where('kd_subkomponen', '<>', '0')
               -> whereIn('kd_akun', $params[2])
               -> where('kd_detail', '0')
               -> get();
    }

    public function scopeAccountList($query, ...$params)
    {
        return $query
               -> where('pakai', true)
               -> where('kd_kegiatan', $params[0])
               -> where('kd_kro', '<>', '000')
               -> where('kd_ro', $params[1])
               -> where('kd_komponen', '<>', '000')
               -> where('kd_subkomponen', '<>', '0')
               -> where('kd_akun', '<>', '000000')
               -> where('kd_detail', '0')
               -> get();
    }

    public function scopeItemList($query, ...$params)
    {
        return $query
               -> where('pakai', true)
               -> where('kd_kegiatan', $params[0])
               -> where('kd_kro', '<>', '000')
               -> where('kd_ro', $params[1])
               -> where('kd_komponen', $params[2])
               -> where('kd_subkomponen', $params[3])
               -> where('kd_akun', $params[4])
               -> where('kd_detail', '<>', '0')
               -> get();
    }

    public function scopeKegiatan($query)
    {
        return $query
               -> where('pakai', true)
               -> where('kd_program', '<>', '00')
               -> where('kd_kegiatan', '<>', '0000')
               -> where('kd_kro', '000')
               -> orderBy('id', 'asc')
               -> get();
    }

    public function scopeBudgetCode($query, $tahun, $kd_akun)
    {
        switch(auth()->user()->roles[0]->name)
        {
            case 'subkoordinator' :
                return $query
                        -> where('pakai', true)
                        -> where('kd_akun', $kd_akun)
                        -> where('tahun', $tahun)
                        -> where('satuan', '<>', '')
                        -> orderBy('id')
                        -> get();
                break;
            case 'koordinator' :
                return $query
                        -> where('kd_akun', $kd_akun)
                        -> where('tahun', $tahun)
                        -> where('satuan', '<>', '')
                        -> whereIn('jabatan_id', Unit::getChild(auth()->user()->jabatan->id))
                        -> orWhere('jabatan_id', auth()->user()->jabatan->id)
                        -> where('pakai', true)
                        -> orderBy('id')
                        -> get();
                break;
            default :
                return $query
                        -> where('pakai', true)
                        -> where('kd_akun', $kd_akun)
                        -> where('tahun', $tahun)
                        -> where('satuan', '<>', '')
                        -> orderBy('id')
                        -> get();
        }
    }

    public function scopeTotalBudget($query)
    {
        return $query->where('pakai', true)
                     ->where('kd_kegiatan', '0000')
                     ->sum('total');
    }
}
