<?php

namespace App\Http\Livewire\Belanja\Lembur;

use App\Models\Pemeriksaan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DaftarPengajuan extends Component
{
    public function render()
    {
        return view('livewire.belanja.lembur.daftar-pengajuan', [
            'listLembur' => Pemeriksaan::with('lemburRelationship')->where('user_id', Auth::user()->id)->get()
        ]);
    }
}
