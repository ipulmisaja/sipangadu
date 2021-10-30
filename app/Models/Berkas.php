<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    protected $table = 'berkas';

    protected $fillable = [
        'reference_id',
        'user_id',
        'file',
        'catatan_file',
        'has_collect',
        'verifikasi',
        'verifikator',
        'catatan_verifikator',
    ];

    public function userRelationship()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function verifikatorRelationship()
    {
        return $this->hasOne(User::class, 'id', 'verifikator');
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
}
