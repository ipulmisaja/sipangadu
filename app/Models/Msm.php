<?php

namespace App\Models;

use App\Traits\StepConfirmable;
use Illuminate\Database\Eloquent\Model;
use Ipulmisaja\Macoa\Helpers\IdGenerator;

class Msm extends Model
{
    use StepConfirmable;

    protected $table = 'msm';

    protected $fillable = [
        'user_id',
        'reference_id',
        'pok_id',
        'catatan',
        'file',
        'tanggal_pengajuan',
        'approve_kf',
        'tanggal_approve_kf',
        'approve_binagram',
        'tanggal_approve_binagram',
        'approve_ppk',
        'tanggal_approve_ppk'
    ];

    protected $casts = [
        'pok_id' => 'array'
    ];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        self::creating(function($model) {
            $model->reference_id = IdGenerator::generate([
                'table'  => 'msm',
                'field'  => 'reference_id',
                'length' => 10,
                'prefix' => 'UP-'
            ]);
        });
    }

    public function getRouteKeyName()
    {
        return 'reference_id';
    }

    public function komentarRelationship()
    {
        return $this->hasMany(Comment::class, 'proposal_id', 'reference_id');
    }

    public function userRelationship()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function pokRelationship()
    {
        return $this->hasOne(Pok::class, 'id', 'pok_id');
    }

    public function scopeKf($query, $unitId)
    {
        return $this->getMsmLevelKf($query)->whereIn('user_id', Unit::getChildUser($unitId));
    }

    public function scopeBinagram($query)
    {
        return $this->getLevelBinagram($query);
    }

    public function scopePpk($query)
    {
        return $this->getLevelPPK($query);
    }
}
