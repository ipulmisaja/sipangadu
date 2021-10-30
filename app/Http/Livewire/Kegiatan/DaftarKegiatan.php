<?php

namespace App\Http\Livewire\Kegiatan;

use App\Models\Kegiatan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarKegiatan extends Component
{
    use WithPagination;

    protected $fullboard;
    protected $overtime;
    protected $trip;

    public $listActivity;

    public function mount()
    {
        if (auth()->user()->hasRole('subkoordinator'))
            $this->listActivity = Kegiatan::with(
                                    ['paketMeetingRelationship', 'lemburRelationship', 'perjadinRelationship'])
                                  -> where('user_id', Auth::user()->id)
                                  -> get();
    }

    public function render()
    {
        return view('livewire.kegiatan.daftar-kegiatan');
    }
}
