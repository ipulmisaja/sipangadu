<?php

namespace App\Http\Livewire\Berkas\Pengumpulan;

use App\Models\Berkas;
use App\Repositories\BerkasRepository;
use Livewire\Component;
use Livewire\WithFileUploads;

class Upload extends Component
{
    use WithFileUploads;

    public $file;
    public $fileNote;
    public $berkas;

    protected $rule = [
        'file'     => 'required',
        'fileNote' => 'nullable|string|min:5'
    ];

    public function mount(Berkas $berkas)
    {
        $this->berkas = $berkas;
    }

    public function render()
    {
        return view('livewire.berkas.pengumpulan.upload');
    }

    public function save(BerkasRepository $berkasRepository)
    {
        $this->validate($this->rule);

        $result = $berkasRepository->store($this);

        session()->flash('message', $result);

        return redirect(env('APP_URL') . 'berkas/daftar-berkas');
    }
}
