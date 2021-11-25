<?php

namespace App\Http\Livewire\TindakLanjut;

use App\Models\Pok;
use App\Models\PencairanAnggaran;
use App\Models\TindakLanjut;
use App\Repositories\FollowUpRepository;
use App\Traits\GenerateDocument;
use Livewire\Component;
use Livewire\WithFileUploads;

class DetailTindakLanjut extends Component
{
    use WithFileUploads;

    public $activity;
    public $activityGroup;
    public $reference_id;
    public $file;
    public $budgetTemp;
    public $volumeTemp;
    public $satuanTemp;


    public function mount($id)
    {
        $this->reference_id = $id;
    }

    public function render()
    {
        $relationship = getModelRelationship($this->reference_id)['relationship'];

        $this->activity = TindakLanjut::with($relationship)->where('reference_id', $this->reference_id)->first();

        $this->budgetTemp = Pok::where('id', $this->activity->$relationship->pok_id)->pluck('total')[0] -
                      PencairanAnggaran::where('pok_id', $this->activity->$relationship->pok_id)->sum('total');

        $this->volumeTemp = Pok::where('id', $this->activity->$relationship->pok_id)->pluck('volume')[0] -
                      PencairanAnggaran::where('pok_id', $this->activity->$relationship->pok_id)->sum('volume');

        $this->satuanTemp = Pok::where('id', $this->activity->$relationship->pok_id)->pluck('satuan')[0];

        $this->activityGroup = array($this->activity, $this->budgetTemp, $this->volumeTemp, $this->satuanTemp);

        // $relationship !== 'tripRelationship' ?: $this->letterOfAssignment($this->reference_id);

        return view('livewire.tindak-lanjut.detail-tindak-lanjut');
    }

    public function followup(FollowUpRepository $followUpRepository, string $reference_id, int $status, string $unit)
    {
        $result = $followUpRepository->followup($reference_id, $unit, $status);

        session()->flash($result['type'], $result['message']);

        return redirect(env('APP_URL') . 'tindak-lanjut/' . $unit);
    }
}
