<?php

namespace App\Http\Livewire\Pemeriksaan;

use App\Models\Pemeriksaan;
use App\Models\Pok;
use App\Models\PencairanAnggaran;
use App\Repositories\PaketMeetingRepository;
use App\Repositories\LemburRepository;
use App\Repositories\PerjadinRepository;
use App\Traits\Commentable;
use Livewire\Component;

class DetailPemeriksaan extends Component
{
    use Commentable;

    /** Model Properties */
    public $activity;
    public $budgetTemp;
    public $volumeTemp;
    public $satuanTemp;
    public $activityGroup;
    public $reference_id;
    public $approval_state;
    public $comment;
    public $spklNumber;
    public $spklDate;
    public $role;
    public $comments;

    protected $rules = [
        'approval_state' => 'required',
        'comment'        => 'required|string',
    ];

    public function mount($id, $role)
    {
        $this->role = $role;

        $this->reference_id = $id;
    }

    public function save()
    {
        // $this->validate($this->rules); mesti dibuat sekretaris dan non sekretaris
        $this->validate($this->rules);

        switch(explode('-', $this->reference_id)[0])
        {
            case "PM":
                $paketMeetingRepository = new PaketMeetingRepository;

                $paketMeetingRepository->updateApproval($this->role, $this);

                session()->flash('message', 'Informasi telah disimpan.');

                return redirect(env('APP_URL') . 'pemeriksaan');

                break;
            case "LB":
                $lemburRepository = new LemburRepository;

                $lemburRepository->updateApproval($this->role, $this);

                session()->flash('message', 'Informasi telah disimpan.');

                return redirect(env('APP_URL') . 'pemeriksaan');

                break;
            case "PD":
                $perjadinRepository = new PerjadinRepository;

                $perjadinRepository->updateApproval($this->role, $this);

                session()->flash('message', 'Informasi telah disimpan.');

                return redirect(env('APP_URL') . 'pemeriksaan');

                break;
        }
    }

    public function render()
    {
        $relationship = getModelRelationship($this->reference_id)['relationship'];

        $this->activity = Pemeriksaan::with($relationship)->where('reference_id', $this->reference_id)->first();

        $this->budgetTemp = Pok::where('id', $this->activity->$relationship->pok_id)->pluck('total')[0] -
                      PencairanAnggaran::where('pok_id', $this->activity->$relationship->pok_id)->sum('total');

        $this->volumeTemp = Pok::where('id', $this->activity->$relationship->pok_id)->pluck('volume')[0] -
                      PencairanAnggaran::where('pok_id', $this->activity->$relationship->pok_id)->sum('volume');

        $this->satuanTemp = Pok::where('id', $this->activity->$relationship->pok_id)->pluck('satuan')[0];

        $this->activityGroup = array($this->activity, $this->budgetTemp, $this->volumeTemp, $this->satuanTemp);

        $this->comments  = $this->getComment($this->activity->$relationship);

        return view('livewire.pemeriksaan.detail-pemeriksaan');
    }
}
