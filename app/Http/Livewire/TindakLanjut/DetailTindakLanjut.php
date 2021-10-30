<?php

namespace App\Http\Livewire\TindakLanjut;

use App\Models\Kegiatan;
use App\Models\Pok;
use App\Models\PencairanAnggaran;
use App\Traits\GenerateDocument;
use Livewire\Component;
use Livewire\WithFileUploads;

class DetailTindakLanjut extends Component
{
    use WithFileUploads;

    public $activity;
    public $activityGroup;
    public $proposalId;
    public $file;

    public function mount($activity)
    {
        $this->proposalId = $activity;
    }

    public function render()
    {
        $relationship = getModelRelationship($this->proposalId)['relationship'];

        $this->activity = Kegiatan::with($relationship)->where('proposal_id', $this->proposalId)->first();

        $budgetTemp = Pok::where('id', $this->activity->$relationship->pok_id)->pluck('total')[0] -
                      PencairanAnggaran::where('pok_id', $this->activity->$relationship->pok_id)->sum('total');

        $volumeTemp = Pok::where('id', $this->activity->$relationship->pok_id)->pluck('volume')[0] -
                      PencairanAnggaran::where('pok_id', $this->activity->$relationship->pok_id)->sum('volume');

        $satuanTemp = Pok::where('id', $this->activity->$relationship->pok_id)->pluck('satuan')[0];

        $this->activityGroup = array($this->activity, $budgetTemp, $volumeTemp, $satuanTemp);

        $relationship !== 'tripRelationship' ?: $this->letterOfAssignment($this->proposalId);

        return view('livewire.tindak-lanjut.detail-tindak-lanjut');
    }
}
