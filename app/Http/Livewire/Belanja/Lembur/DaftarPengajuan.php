<?php

namespace App\Http\Livewire\Belanja\Lembur;

use App\Models\Lembur;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarPengajuan extends Component
{
    use WithPagination;

    public $listLembur;
    public $stage;

    public function mount()
    {
        $this->listLembur = $this->userQuery();

        $this->stage = 'user';
    }

    public function render()
    {
        return view('livewire.belanja.lembur.daftar-pengajuan');
    }

    public function user()
    {
        $this->listLembur = $this->userQuery();

        $this->stage = 'user';
    }

    public function admin()
    {
        $this->listLembur = $this->adminQuery();

        $this->stage = 'admin';
    }

    private function userQuery()
    {
        return Lembur::with('pemeriksaanRelationship')
                    -> where('user_id', Auth::user()->id)
                    -> orderBy('tanggal_pengajuan', 'desc')
                    -> get();
    }

    private function adminQuery()
    {
        return Lembur::with('pemeriksaanRelationship')
                    -> orderBy('tanggal_pengajuan', 'desc')
                    -> get();
    }
}
