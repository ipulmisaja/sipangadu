<?php

namespace App\Http\Livewire\Belanja\Lembur;

use App\Models\Lembur;
use App\Traits\Commentable;
use Livewire\Component;

class DetailPengajuan extends Component
{
    use Commentable;

    public $lembur;
    public $comments;

    public function mount(Lembur $id)
    {
        $this->lembur = $id;

        $this->comments = $this->getComment($id);
    }

    public function render()
    {
        return view('livewire.belanja.lembur.detail-pengajuan');
    }
}
