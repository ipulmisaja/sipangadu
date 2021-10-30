<?php

namespace App\Traits;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

trait StepConfirmable
{
    /**
     * Mengembalikan informasi msm
     * yang belum diperiksa oleh KF atau Kabag
     * @param mixed $query
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getMsmLevelKf($query) : Collection
    {
        return $query
               -> where('approve_kf', 0)
               -> get();
    }

    /**
     * Mengembalikan informasi msm/kegiatan
     * yang belum diperiksa oleh KF atau Kabag
     * @param mixed $query
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getKegiatanLevelKf($query) : Collection
    {
        return $query
               -> whereIn('user_id', Unit::getChildUser(Auth::user()->unitRelationship->id))
               -> where('approve_kf', 0)
               -> get();
    }

    /**
     * Mengembalikan informasi msm/kegiatan
     * yang belum diperiksa binagram
     * @param mixed $query
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getLevelBinagram($query) : Collection
    {
        return $query
               -> where('approve_kf', 1)
               -> where('approve_binagram', 0)
               -> get();
    }

    /**
     * Mengembalikan informasi msm/kegiatan
     * yang belum diperiksa ppk
     * @param mixed $query
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getLevelPPK($query) : Collection
    {
        return $query
               -> where('approve_kf', 1)
               -> whereNotNull('approve_binagram')
               -> where('approve_ppk', 0)
               -> get();
    }

    /**
     * Mengembalikan informasi msm/kegiatan
     * yang belum di followup sekretaris
     * @param mixed $query
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getLevelSekretaris($query) : Collection
    {
        return $query
               -> where('reference_id', 'like', 'LB%')
               -> where('approve_kf', 1)
               -> whereNotNull('approve_binagram')
               -> where('approve_ppk', 1)
               -> where('followup_sekretaris', 0)
               -> get();
    }

    /**
     * Mengembalikan informasi msm/kegiatan
     * yang belum diperiksan kepala bps
     * @param mixed $query
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getLevelKepala($query)
    {
        return $query
               -> where('reference_id', 'not like', "FB%")
               -> where('approve_kf', 1)
               -> whereNotNull('approve_binagram')
               -> where('approve_ppk', 1)
               -> where(function($q) {
                    $q->where('reference_id', 'like', "PD%")->where('approve_kepala', 0);
               })
               -> orWhere(function($q) {
                    $q->where('reference_id', 'like', "LB%")->where('followup_sekretaris', 1);
                })
                -> where('approve_kepala', 0)
               -> get();
    }
}
