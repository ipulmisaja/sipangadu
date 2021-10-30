<?php

namespace App\Http\Livewire\Berkas\Pengumpulan;

use App\Models\Berkas;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarBerkas extends Component
{
    use WithPagination;

    public $daftarBerkas;
    public $activityType;

    public function mount()
    {
        $this->daftarBerkas =
            Berkas::with(['paketMeetingRelationship', 'lemburRelationship', 'perjadinRelationship'])
                     ->where('user_id', Auth::user()->id)
                     ->get();
    }

    public function updatedActivityType($value)
    {
        $this->activityType =
            Berkas::with(['paketMeetingRelationship', 'lemburRelationship', 'perjadinRelationship'])
                     ->where('proposal_id', 'like', "$value%")
                     ->where('user_id', Auth::user()->id)
                     ->get();
    }

    public function render()
    {
        return view('livewire.berkas.pengumpulan.daftar-berkas');
    }
}
