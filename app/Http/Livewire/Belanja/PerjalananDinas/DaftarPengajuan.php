<?php

namespace App\Http\Livewire\Belanja\PerjalananDinas;

use App\Models\PerjalananDinas;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarPengajuan extends Component
{
    use WithPagination;

    public $listPerjadin;
    public $stage;

    public function mount()
    {
        $this->listPerjadin = $this->userQuery();

        $this->stage = 'user';
    }

    public function render()
    {
        return view('livewire.belanja.perjalanan-dinas.daftar-pengajuan');
    }

    public function user()
    {
        $this->resetPage();

        $this->listPerjadin = $this->userQuery();

        $this->stage = 'user';
    }

    public function admin()
    {
        $this->resetPage();

        $this->listPerjadin = $this->adminQuery();

        $this->stage = 'admin';
    }

    private function userQuery()
    {
        return PerjalananDinas::with('pemeriksaanRelationship')
                    -> where('user_id', Auth::user()->id)
                    -> orderBy('tanggal_pengajuan', 'desc')
                    -> get();
    }

    private function adminQuery()
    {
        return PerjalananDinas::with('pemeriksaanRelationship')
                    -> orderBy('tanggal_pengajuan', 'desc')
                    -> get();
    }
}
