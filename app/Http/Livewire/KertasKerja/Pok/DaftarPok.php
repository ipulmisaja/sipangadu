<?php

namespace App\Http\Livewire\KertasKerja\Pok;

use App\Models\Pok;
use Livewire\Component;

class DaftarPok extends Component
{
    public function render()
    {
        return view('livewire.kertas-kerja.pok.daftar-pok', [
            'daftarPok' => Pok::distinct(['tahun', 'revisi'])->get()
        ]);
    }
}
