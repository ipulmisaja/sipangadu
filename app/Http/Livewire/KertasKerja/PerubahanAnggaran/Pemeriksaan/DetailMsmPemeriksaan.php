<?php

namespace App\Http\Livewire\KertasKerja\PerubahanAnggaran\Pemeriksaan;

use App\Models\Msm;
use App\Repositories\MsmRepository;
use App\Traits\Commentable;
use App\Traits\MsmPokValidation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DetailMsmPemeriksaan extends Component
{
    use Commentable, MsmPokValidation;

    /** Model Properties */
    public $pok;
    public $approval_state;
    public $comment;
    public $role;
    public $comments;

    /** Modal Property */
    public $modal = false;

    protected $listeners = ['close'];

    public function mount(Msm $refid, $role)
    {
        $this->pok  = $refid;
        $this->role = $role;

        $this->comments = $this->getComment($refid);
    }

    public function approval()
    {
        $this->modal = true;
    }

    public function close()
    {
        $this->modal = false;
    }

    public function save(MsmRepository $msmRepository)
    {
        $this->validateInspection($this);

        $msmRepository->updateApproval($this->role, $this);

        $this->modal = false;

        return redirect(env('APP_URL') . 'kertas-kerja/pemeriksaan-msm');
    }

    public function render()
    {
        return view('livewire.kertas-kerja.perubahan-anggaran.pemeriksaan.detail-msm-pemeriksaan');
    }
}
