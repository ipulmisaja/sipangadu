<?php

namespace App\Http\Livewire\KertasKerja\PerubahanAnggaran\Proposal;

use App\Models\Msm;
use App\Traits\Commentable;
use Livewire\Component;

class DetailMsmProposal extends Component
{
    use Commentable;

    /** @var Msm */
    public $reference;

    /** @var Komentar */
    public $comments;

    public function mount(Msm $reference)
    {
        $this->reference = $reference;

        $this->comments  = $this->getComment($reference);
    }

    public function render()
    {
        return view('livewire.kertas-kerja.perubahan-anggaran.proposal.detail-msm-proposal');
    }
}
