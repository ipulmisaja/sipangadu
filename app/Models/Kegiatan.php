<?php

namespace App\Models;

use App\Traits\StepConfirmable;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use StepConfirmable;

    protected $table = 'kegiatan';

    protected $fillable = [
        'user_id',
        'proposal_id',
        'tanggal_proposal',
        'approve_kf',
        'tanggal_approve_kf',
        'approve_binagram',
        'tanggal_approve_binagram',
        'approve_ppk',
        'tanggal_approve_ppk',
        'followup_sekretaris',
        'tanggal_followup_sekretaris',
        'approve_kepala',
        'tanggal_approve_kepala'
    ];

    public $timestamps = false;

    public function paketMeetingRelationship()
    {
        return $this->hasOne(PaketMeeting::class, 'reference_id', 'proposal_id');
    }

    public function lemburRelationship()
    {
        return $this->hasOne(Lembur::class, 'reference_id', 'proposal_id');
    }

    public function perjadinRelationship()
    {
        return $this->hasOne(PerjalananDinas::class, 'reference_id', 'proposal_id');
    }

    public function userRelationship()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeKf($query)
    {
        return $this->getKegiatanLevelKf($query);
    }

    public function scopeBinagram($query)
    {
        return $this->getLevelBinagram($query);
    }

    public function scopePpk($query)
    {
        return $this->getLevelPPK($query);
    }

    public function scopeSekretaris($query)
    {
        return $this->getLevelSekretaris($query);
    }

    public function scopeKepala($query)
    {
        return $this->getLevelKepala($query);
    }
}
