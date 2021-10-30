<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\PencairanAnggaran;
use App\Models\Pok;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    /** Modal Property */
    public $changePasswordModal = false;

    /** Listener Properties */
    protected $listeners = ['notify', 'close'];

    public function mount()
    {
        if (!Auth::user()->ubah_password) $this->changePasswordModal = true;
    }

    public function notify($message)
    {
        session()->flash('message', $message);
    }

    public function close()
    {
        $this->changePasswordModal = false;
    }

    public function render()
    {
        // realisasi
        // sisa
        // daftar orang dl sort by jumlah dl

        return view('livewire.dashboard.index', [
            'total' => Pok::totalBudget(),
            'realization' => PencairanAnggaran::realizationBudget()
        ]);
    }
}
