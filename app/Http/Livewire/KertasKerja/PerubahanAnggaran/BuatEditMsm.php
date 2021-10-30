<?php

namespace App\Http\Livewire\KertasKerja\PerubahanAnggaran;

use App\Models\Pok;
use App\Repositories\MsmRepository;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class BuatEditMsm extends Component
{
    use WithFileUploads;

    /** Select List Properties */
    public $activityList;
    public $outputList;
    public $componentList;

    /** Wire Model Properties */
    public $activity;
    public $output;
    public $component;
    public $description;
    public $file;

    /**  Array Component */
    public $componentArray = [];
    public $componentArrayStore = [];

    /** Beginning Property */
    public $title;
    public $method;

    protected $rules = [
        'activity'    => 'required',
        'output'      => 'required',
        'component'   => 'required',
        'description' => 'required|string|min:5',
        'file'        => 'required'
    ];

    public function mount()
    {
        if (Str::contains(request()->getPathInfo(), 'buat')) {
            $this->title  = 'Pengajuan MSM Baru';
            $this->method = 'save';
        } else {
            $this->title  = 'Edit MSM';
            $this->method = 'update';
        }
    }

    public function render()
    {
        $this->activityList = Pok::kegiatan();

        $this->outputList =
            $this->activity === 'null'
                ? []
                : Pok::outputList('=', $this->activity);

        $this->componentList =
            $this->output === 'null'
                ? []
                : Pok::componentList($this->activity, $this->output);

        return view('livewire.kertas-kerja.perubahan-anggaran.buat-edit-msm');
    }

    public function save(MsmRepository $msmRepository)
    {
        $this->validate($this->rules);

        $result = $msmRepository->store($this);

        session()->flash('message', $result);

        return redirect(env('APP_URL') . 'kertas-kerja/pengajuan-msm');
    }

    public function updatedComponent($value)
    {
        $param = explode('.', $value);

        array_push($this->componentArrayStore, $param[0]);

        array_push($this->componentArray, $param[1]);
    }

    public function deleteComponent($value)
    {
        if (($key = array_search($value, $this->componentArray)) !== false) {
            unset($this->componentArray[$key]);
        }
    }
}
