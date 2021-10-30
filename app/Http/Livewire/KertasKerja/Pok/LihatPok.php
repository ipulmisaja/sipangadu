<?php

namespace App\Http\Livewire\KertasKerja\Pok;

use App\Models\Pok;
use Livewire\Component;

class LihatPok extends Component
{
    /** Livewire Properties */
    public $year;
    public $version;
    public $pok;

    /** Select Option Properties */
    public $activityList;
    public $roList;

    /** Select Model Properties */
    public $activity = 'null';
    public $ro = 'null';

    public function mount($tahun, $versi)
    {
        $this->year = $tahun;

        $this->version = $versi;

        $this->pok =
            Pok::where('tahun', $tahun)
               ->where('revisi', $versi)
               ->orderBy('id', 'asc')
               ->get();

        $this->activityList =
            Pok::where('tahun', $tahun)
               ->where('revisi', $versi)
               ->where('kd_kegiatan', '<>', '0000')
               ->where('kd_kro', '000')
               ->get();
    }

    public function updatedActivity($value)
    {
        if ($value === 'null') {
            $this->pok = Pok::query()
                         -> where('tahun', $this->year)
                         -> where('revisi', $this->version)
                         -> orderBy('id', 'asc')
                         -> get();
        } else {
            $splitActivity = explode('.', $value);

            $this->roList = Pok::query()
                               -> where('tahun', $this->year)
                               -> where('revisi', $this->version)
                               -> where('kd_kegiatan', $splitActivity[3])
                               -> where('kd_kro', '<>', '000')
                               -> where('kd_ro', '<>', '000')
                               -> where('kd_komponen', '000')
                               -> get();

            $this->pok = Pok::query()
                         -> where('tahun', $this->year)
                         -> where('revisi', $this->version)
                         -> where('kd_departemen', $splitActivity[0])
                         -> where('kd_organisasi', $splitActivity[1])
                         -> where('kd_program', $splitActivity[2])
                         -> where('kd_kegiatan', $splitActivity[3])
                         -> orderBy('id', 'asc')
                         -> get();
        }
    }

    public function updatedRo($value)
    {
        if($this->activity === 'null') {
            $this->ro  = 'null';

            $this->pok = Pok::query()
                            -> where('tahun', $this->year)
                            -> where('revisi', $this->version)
                            -> orderBy('id', 'asc')
                            -> get();
        } else {
            $splitActivity = explode('.', $this->activity);
            if ($value === 'null') {
                $this->pok = Pok::query()
                            -> where('tahun', $this->year)
                            -> where('revisi', $this->version)
                            -> where('kd_departemen', $splitActivity[0])
                            -> where('kd_organisasi', $splitActivity[1])
                            -> where('kd_program', $splitActivity[2])
                            -> where('kd_kegiatan', $splitActivity[3])
                            -> orderBy('id', 'asc')
                            -> get();
            } else {
                $splitRo = explode('.', $value);
                $this->pok = Pok::query()
                             -> where('tahun', $this->year)
                             -> where('revisi', $this->version)
                             -> where('kd_departemen', $splitActivity[0])
                             -> where('kd_organisasi', $splitActivity[1])
                             -> where('kd_program', $splitActivity[2])
                             -> where('kd_kegiatan', $splitActivity[3])
                             -> where('kd_kro', $splitRo[1])
                             -> where('kd_ro', $splitRo[2])
                             -> orderBy('id', 'asc')
                             -> get();
            }
        }
    }

    public function render()
    {
        if ($this->activity === 'null') $this->roList = [];

        return view('livewire.kertas-kerja.pok.lihat-pok');
    }
}
