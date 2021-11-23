<?php

namespace App\Http\Livewire\Belanja\PaketMeeting;

use App\Models\PaketMeeting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarPengajuan extends Component
{
    use WithPagination;

    public $listPaketMeeting;
    public $stage;

    public function mount()
    {
        $this->listPaketMeeting = $this->userQuery();

        $this->stage = 'user';
    }

    public function render()
    {
        return view('livewire.belanja.paket-meeting.daftar-pengajuan');
    }

    public function user()
    {
        $this->listPaketMeeting = $this->userQuery();

        $this->stage = 'user';
    }

    public function admin()
    {
        $this->listPaketMeeting = $this->adminQuery();

        $this->stage = 'admin';
    }

    private function userQuery()
    {
        return PaketMeeting::with('pemeriksaanRelationship')
                    -> where('user_id', Auth::user()->id)
                    -> orderBy('tanggal_pengajuan', 'desc')
                    -> get();
    }

    private function adminQuery()
    {
        return PaketMeeting::with('pemeriksaanRelationship')
                    -> orderBy('tanggal_pengajuan', 'desc')
                    -> get();
    }
}
