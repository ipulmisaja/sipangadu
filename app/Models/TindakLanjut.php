<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TindakLanjut extends Model
{
    protected $table = 'tindak_lanjut';

    protected $fillable = [
        'reference_id',
        'tanggal_dibuat'
    ];

    public $timestamps = false;

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
