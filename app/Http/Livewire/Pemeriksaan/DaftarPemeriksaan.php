<?php

namespace App\Http\Livewire\Pemeriksaan;

use App\Models\Pemeriksaan;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarPemeriksaan extends Component
{
    use WithPagination;

    public $checkByAdmin;
    public $checkByCoordinator;
    public $checkByPlanner;
    public $checkByCommitOfficer;
    public $checkBySecretary;
    public $checkByHeadOffice;

    public function mount()
    {
        foreach (auth()->user()->roles as $role)
        {
            switch($role->name)
            {
                case 'koordinator':
                    $this->checkByCoordinator = Pemeriksaan::query()
                                                -> with(['userRelationship', 'paketMeetingRelationship', 'lemburRelationship', 'perjadinRelationship'])
                                                -> kf();
                    break;
                case 'binagram':
                    $this->checkByPlanner = Pemeriksaan::query()
                                            -> with(['userRelationship', 'paketMeetingRelationship', 'lemburRelationship', 'perjadinRelationship'])
                                            -> binagram();
                    break;
                case 'ppk':
                    $this->checkByCommitOfficer = Pemeriksaan::query()
                                                  -> with(['userRelationship', 'paketMeetingRelationship', 'lemburRelationship', 'perjadinRelationship'])
                                                  -> ppk();
                    break;
                case 'sekretaris':
                    $this->checkBySecretary = Pemeriksaan::query()
                                              -> with('lemburRelationship')
                                              -> sekretaris();
                    break;
                case 'kpa':
                    $this->checkByHeadOffice = Pemeriksaan::query()
                                               -> with(['userRelationship', 'lemburRelationship', 'perjadinRelationship'])
                                               -> kepala();
                                               
                    break;
            }
        }
    }

    public function render()
    {
        return view('livewire.pemeriksaan.daftar-pemeriksaan');
    }
}
