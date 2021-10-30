<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasRoles, Notifiable, SoftDeletes;

    protected $table = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'username',
        'password',
        'ubah_password',
        'slug',
        'email',
        'bps_id',
        'nip_id',
        'pangkat_golongan_id',
        'foto',
        'unit_id',
        'telegram_id'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function unitRelationship()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function pangkatGolonganRelationship()
    {
        return $this->hasOne(PangkatGolongan::class, 'id', 'pangkat_golongan_id');
    }

    public function alokasiPerjadinRelationship()
    {
        return $this->hasMany(AlokasiPerjalananDinas::class, 'user_id', 'id');
    }

    public function hasUnit($item)
    {
        if(is_string($item)) {
            return $this->unitRelationship->slug === $item
                ? true
                : false;
        }

        if(is_array($item)) {
            foreach ($item as $data) {
                if ($this->unitRelationship->slug === $data) return true;
            }

            return false;
        }
    }
}
