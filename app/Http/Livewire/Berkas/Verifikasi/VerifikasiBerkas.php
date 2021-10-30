<?php

namespace App\Http\Livewire\Berkas\Verifikasi;

use App\Models\Berkas;
use App\Repositories\BerkasRepository;
use Livewire\Component;

class VerifikasiBerkas extends Component
{
    public $verifikasi;
    public $statusVerifikasi;
    public $catatanVerifikasi;
    public $hasCollect = false;

    protected $rules = [
        'statusVerifikasi'  => 'required',
        'catatanVerifikasi' => 'required|string|min:5'
    ];

    public function mount(Berkas $id)
    {
        $this->verifikasi = $id;
    }

    public function save(BerkasRepository $berkasRepository)
    {
        $this->validate($this->rules);

        $result = $berkasRepository->verification($this);

        session()->flash('message', $result);

        return redirect('berkas/daftar-verifikasi/subkoordinator-keuangan');
    }

    public function render()
    {
        return view('livewire.berkas.verifikasi.verifikasi-berkas');
    }
}
