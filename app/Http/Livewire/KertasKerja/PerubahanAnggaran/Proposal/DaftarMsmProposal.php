<?php

namespace App\Http\Livewire\KertasKerja\PerubahanAnggaran\Proposal;

use App\Models\Msm;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DaftarMsmProposal extends Component
{
    /** @var collection */
    public $msmList;

    public function hydrate()
    {
        $this->msmList = Msm::where('user_id', Auth::user()->id)->get();
    }

    public function render()
    {
        $this->msmList = Msm::where('user_id', Auth::user()->id)->get();

        return view('livewire.kertas-kerja.perubahan-anggaran.proposal.daftar-msm-proposal');
    }
}
