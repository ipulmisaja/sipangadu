<?php

namespace App\Http\Livewire\Berkas\Realisasi;

use App\Models\Lembur;
use App\Models\PaketMeeting;
use App\Models\PerjalananDinas;
use App\Models\Pok;
use App\Models\PencairanAnggaran;
use App\Repositories\RealisasiRepository;
use Livewire\Component;

class Entri extends Component
{
    /** Pre Rendered Properties */
    public $outputList;
    public $accountList;
    public $detailList;

    /** Wire Model Properties */
    public $realisasi = null;
    public $name = null;
    public $spmNumber;
    public $spmDate;
    public $volume;
    public $total;
    public $availableBudget;
    public $availableVolume;
    public $measure;
    public $output = 'null';
    public $account = 'null';
    public $detail = 'null';


    protected $rules = [
        'name'      => 'nullable|string|min:3',
        'volume'    => 'required|lte:availableVolume',
        'total'     => 'required|lte:availableBudget'
    ];

    public function mount(PencairanAnggaran $realisasi)
    {
        if (count($realisasi->getOriginal()) > 0) {
            $this->realisasi = $realisasi;

            if (!is_null($realisasi->reference_id)) {
                $relationship = getModelRelationship($realisasi->reference_id)['relationship'];

                $this->name = $realisasi->$relationship->nama;

                switch($relationship) {
                    case 'paketMeetingRelationship' :
                        $this->volume = PaketMeeting::where('reference_id', $realisasi->reference_id)->first('volume')->volume;

                        $this->total = PaketMeeting::where('reference_id', $realisasi->reference_id)->first('total')->total;

                        break;
                    case 'perjadinRelationship' :
                        $this->volume = PerjalananDinas::where('reference_id', $realisasi->reference_id)->first('volume')->volume;

                        $this->total = PerjalananDinas::where('reference_id', $realisasi->reference_id)->first('total')->total;

                        break;
                }
            }

            $this->availableBudget = $realisasi->pokRelationship->total -
                                     PencairanAnggaran::where('pok_id', $realisasi->pok_id)->sum('total');

            $this->availableVolume = $realisasi->pokRelationship->volume -
                                     PencairanAnggaran::where('pok_id', $realisasi->pok_id)->sum('volume');

            $this->measure = $realisasi->pokRelationship->satuan;
        }
    }

    public function updatedDetail($val)
    {
        $this->availableBudget =
            Pok::where('pakai', true)->where('id', $val)->pluck('total')[0] -
            PencairanAnggaran::where('pok_id', $val)->sum('total');

        $this->availableVolume =
            Pok::where('pakai', true)->where('id', $val)->pluck('volume')[0] -
            PencairanAnggaran::where('pok_id', $val)->sum('volume');

        $this->measure = Pok::where('pakai', true)->where('id', $val)->pluck('satuan')[0];
    }

    # FIXME: masih muncul validasi isian
    public function truncate($id)
    {
        PencairanAnggaran::where('id', $id)->update([
            'spm_date' => null,
            'total'    => null,
            'volume'   => null
        ]);
    }

    public function render()
    {
        $this->outputList = Pok::outputList('<>', '0000');

        $this->accountList =
            $this->output === 'null'
                ? []
                : Pok::accountList(
                    explode('.', $this->output)[0],
                    explode('.', $this->output)[2]
                );

        $this->detailList =
            $this->account === 'null'
                ? []
                : Pok::itemList(
                    explode('.', $this->output)[0],
                    explode('.', $this->output)[2],
                    explode('.', $this->account)[0],
                    explode('.', $this->account)[1],
                    explode('.', $this->account)[2]
                );

        return view('livewire.berkas.realisasi.entri');
    }

    public function save(RealisasiRepository $realisasiRepository)
    {
        $this->validate($this->rules);

        $result = $realisasiRepository->store($this);

        session()->flash('message', $result);

        return redirect(env('APP_URL') . 'berkas/realisasi-anggaran');
    }
}
