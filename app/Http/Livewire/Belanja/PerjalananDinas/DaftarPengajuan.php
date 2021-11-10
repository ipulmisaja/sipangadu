<?php

namespace App\Http\Livewire\Belanja\PerjalananDinas;

use App\Models\PerjalananDinas;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DaftarPengajuan extends Component
{
    public function render()
    {
        return view('livewire.belanja.perjalanan-dinas.daftar-pengajuan', [
            'listPerjadin' => PerjalananDinas::where('user_id', Auth::user()->id)->get()
        ]);
    }
}
