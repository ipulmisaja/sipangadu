<?php

namespace App\Http\Livewire\KertasKerja\PerubahanAnggaran\Pemeriksaan;

use App\Models\Msm;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DaftarMsmPemeriksaan extends Component
{
    public $checkByAdmin;
    public $checkByCoordinator;
    public $checkByPlanner;
    public $checkByCommitOfficer;

    public function mount()
    {
        foreach(auth()->user()->roles as $role)
        {
            switch($role->name) {
                case 'koordinator':
                    $this->checkByCoordinator = Msm::kf(Auth::user()->unit_id);
                    break;
                case 'binagram':
                    $this->checkByPlanner = Msm::binagram();
                    break;
                case 'ppk':
                    $this->checkByCommitOfficer = Msm::ppk();
                    break;
            }
        }
    }

    public function render()
    {
        return view('livewire.kertas-kerja.perubahan-anggaran.pemeriksaan.daftar-msm-pemeriksaan');
    }
}
