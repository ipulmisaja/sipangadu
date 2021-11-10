<?php

namespace App\Http\Livewire\Belanja\PaketMeeting;

use App\Models\PaketMeeting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DaftarPengajuan extends Component
{
    public function render()
    {
        return view('livewire.belanja.paket-meeting.daftar-pengajuan', [
            'listPaketMeeting' => PaketMeeting::with('pemeriksaanRelationship')->where('user_id', Auth::user()->id)->get()
        ]);
    }
}
