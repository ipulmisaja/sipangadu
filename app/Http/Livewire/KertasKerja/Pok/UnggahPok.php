<?php

namespace App\Http\Livewire\KertasKerja\Pok;

use App\Repositories\Pok\PokRepository;
use Livewire\Component;
use Livewire\WithFileUploads;

class UnggahPok extends Component
{
    use WithFileUploads;

    public $tahun;
    public $pok;

    protected $rules = [
        'tahun'  => 'required',
        'pok'    => 'required'
    ];

    public function render()
    {
        return view('livewire.kertas-kerja.pok.unggah-pok');
    }

    public function save(PokRepository $pokRepository)
    {
        $this->validate($this->rules);

        $result = $pokRepository->store($this);

        session()->flash('message', $result);

        return redirect(env('APP_URL') . 'kertas-kerja/daftar-pok');
    }
}
