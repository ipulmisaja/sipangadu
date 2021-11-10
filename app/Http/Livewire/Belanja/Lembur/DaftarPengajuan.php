<?php

namespace App\Http\Livewire\Belanja\Lembur;

use App\Models\Lembur;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DaftarPengajuan extends Component
{
    public function render()
    {
        return view('livewire.belanja.lembur.daftar-pengajuan', [
            'listLembur' => Lembur::where('user_id', Auth::user()->id)->get()
        ]);
    }
}
