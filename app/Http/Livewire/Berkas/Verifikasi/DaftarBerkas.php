<?php

namespace App\Http\Livewire\Berkas\Verifikasi;

use App\Models\Berkas;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarBerkas extends Component
{
    use WithPagination;

    public $daftarVerifikasi;
    public $role;
    public $activityType;

    public function mount($role)
    {
        $this->role = $role;

        switch($role)
        {
            case 'ppk' :
                $this->daftarVerifikasi =
                    Berkas::with(['paketMeetingRelationship', 'lemburRelationship', 'perjadinRelationship'])
                          -> where('verifikasi', 1)
                          -> orderBy('created_at', 'desc')
                          -> get();

                break;
            case 'subkoordinator-keuangan' :
                $this->daftarVerifikasi =
                    Berkas::with(['paketMeetingRelationship', 'lemburRelationship', 'perjadinRelationship'])
                        -> whereNotNull('file')
                        -> orderBy('verifikasi', 'desc')
                        -> orderBy('created_at', 'desc')
                        -> get();

                break;
        }

    }

    // public function updatedActivityType($value)
    // {
    //     $this->verificationList =
    //         Payment::with(['paketMeetingRelationship', 'lemburRelationship', 'perjadinRelationship'])
    //                ->where('proposal_id', 'like', "$value%")
    //                ->whereNotNull('file')
    //                ->orderBy('verification', 'asc')
    //                ->get();
    // }

    public function render()
    {
        return view('livewire.berkas.verifikasi.daftar-berkas');
    }
}
