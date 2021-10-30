<?php

namespace App\Http\Livewire\Belanja\PerjalananDinas;

use App\Models\Pok;
use App\Models\PencairanAnggaran;
use App\Models\PerjalananDinas;
use App\Traits\Commentable;
use Livewire\Component;

class DetailPengajuan extends Component
{
    use Commentable;

    public $perjadin;
    public $comments;
    public $availableBudget;
    public $availableVolume;
    public $satuan;

    public function mount(PerjalananDinas $id)
    {
        $this->perjadin = $id;

        $this->comments = $this->getComment($id);

        $this->availableBudget = Pok::where('id', $this->perjadin->pok_id)->pluck('total')[0] -
                                 PencairanAnggaran::where('pok_id', $this->perjadin->pok_id)->sum('total');

        $this->availableVolume = Pok::where('id', $this->perjadin->pok_id)->pluck('volume')[0] -
                                 PencairanAnggaran::where('pok_id', $this->perjadin->pok_id)->sum('volume');

        $this->satuan = Pok::where('id', $this->perjadin->pok_id)->pluck('satuan')[0];
    }

    public function render()
    {
        return view('livewire.belanja.perjalanan-dinas.detail-pengajuan');
    }
}
