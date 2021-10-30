<?php

namespace App\Http\Livewire\Belanja\PerjalananDinas;

use App\Models\PerjalananDinas;
use App\Models\Pok;
use App\Models\PencairanAnggaran;
use App\Models\AlokasiPerjalananDinas;
use App\Models\User;
use App\Repositories\PerjadinRepository;
use App\Traits\ValidasiBelanja;
use Ipulmisaja\Macoa\Helpers\InputMask;
use Livewire\Component;

class BuatPengajuan extends Component
{
    use ValidasiBelanja;

    private $GENERAL_TRIP = '524111';
    private $CITY_TRIP = '524113';

    /** Pre Rendered Properties */
    public $outputList;
    public $accountList;
    public $detailList;
    public $availableBudget;
    public $availableVolume;
    public $satuan;
    public $tripList = [];
    public $employees = [];


    public $tanggal_pengajuan;
    public $nota_dinas;
    public $nama_kegiatan;
    public $output = 'null';
    public $account = 'null';
    public $detail = 'null';
    public $budget;
    public $volume;
    public $catatan;

    /** Model Property */
    public $trip;

    public function mount()
    {
        // $this->employees = User::orderBy('id', 'asc')->get();

        $this->tripList  = [
            []
        ];
    }

    public function render()
    {
        $this->outputList = Pok::outputList('<>', '0000');

        $this->accountList =
            $this->output === 'null'
                ? []
                : Pok::detailList(
                    explode('.', $this->output)[0],
                    explode('.', $this->output)[2],
                    [$this->GENERAL_TRIP, $this->CITY_TRIP]
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

        $this->availableBudget =
            $this->detail === 'null'
                ? []
                : number_format(
                    Pok::where('pakai', true)->where('id', $this->detail)->pluck('total')[0] -
                    PencairanAnggaran::where('pok_id', $this->detail)->sum('total'), 0, ',', '.'
                    ) . ",-";

        $this->availableVolume =
            $this->detail === 'null'
                ? []
                : Pok::where('pakai', true)->where('id', $this->detail)->pluck('volume')[0] -
                    PencairanAnggaran::where('pok_id', $this->detail)->sum('volume');

        $this->satuan =
            $this->detail === 'null'
                ? '-'
                : Pok::where('pakai', true)->where('id', $this->detail)->pluck('satuan')[0];

        # FIXME: bermasalah dengan user yang belum dialokasikan perjadinnya
        // $this->employees =
        //     $this->detail === 'null'
        //         ? []
        //         : (AlokasiPerjalananDinas::with('userRelationship')->where('pok_id', $this->detail)->count() > 0)
        //             ? AlokasiPerjalananDinas::with('userRelationship')->where('pok_id', $this->detail)->get()
        //             : User::orderBy('id', 'asc')->get();

        $this->employees = User::orderBy('id', 'asc')->get();

        return view('livewire.belanja.perjalanan-dinas.buat-pengajuan');
    }

    public function addRow()
    {
        $this->tripList[] = [];

        $this->dispatchBrowserEvent('flatpickr', []);
    }

    public function deleteRow($index)
    {
        unset($this->tripList[$index]);

        array_values($this->tripList);

        $this->dispatchBrowserEvent('flatpickr', []);
    }

    public function save(PerjadinRepository $perjadinRepository)
    {
        $temp = str_replace(".", "", $this->budget);

        $this->budget = intval($temp);

        $this->perjadinValidasi($this);

        $result = $perjadinRepository->store($this);

        session()->flash('message', $result);

        return redirect(env('APP_URL') . 'belanja/perjalanan-dinas');
    }

    public function updatedBudget()
    {
        $this->budget = str_replace(".", "", $this->budget);

        if ($this->budget !== '') $this->budget = InputMask::mask($this->budget, number_format($this->budget, 0, ',', '.'));
    }
}
