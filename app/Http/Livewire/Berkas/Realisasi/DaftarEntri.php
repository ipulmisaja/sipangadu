<?php

namespace App\Http\Livewire\Berkas\Realisasi;

use App\Models\PencairanAnggaran;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarEntri extends Component
{
    use WithPagination;

    public $daftarRealisasi;
    public $activityType;

    public function mount()
    {
        $this->daftarRealisasi = PencairanAnggaran::orderByRaw("CASE WHEN spm IS NULL THEN 0 ELSE 1 END ASC")->orderBy('spm', 'DESC')->get();
    }

    public function render()
    {
        return view('livewire.berkas.realisasi.daftar-entri');
    }

    public function updatedActivityType($value)
    {
        dd($this->realizationList->where(''));
    }
}
