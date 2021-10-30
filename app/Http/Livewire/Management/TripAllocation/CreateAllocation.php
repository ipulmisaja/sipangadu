<?php

namespace App\Http\Livewire\Management\TripAllocation;

use App\Models\Pok;
use App\Models\AlokasiPerjalananDinas;
use App\Models\User;
use App\Repositories\TripAllocationRepository;
use Livewire\Component;

class CreateAllocation extends Component
{
    private $GENERAL_TRIP = '524111';
    private $CITY_TRIP = '524113';

    public $tripAllocationList = [];
    public $employees = [];

    public $unitId;
    public $outputList;
    public $accountList;
    public $detailList;
    public $availableBudget;
    public $availableVolume;
    public $output = 'null';
    public $account = 'null';
    public $detail = 'null';
    public $measure;
    public $userId;
    public $total;

    public function mount()
    {
        $this->employees = User::orderBy('id', 'asc')->get();

        $this->tripAllocationList = [
            []
        ];
    }

    public function render()
    {
        $this->outputList = Pok::where('unit_id', $this->unitId)->outputList('<>', '0000');

        $this->accountList =
            $this->output === 'null'
                ? []
                : Pok::where('pakai', true)->detailList(
                    explode('.', $this->output)[0],
                    explode('.', $this->output)[2],
                    [$this->GENERAL_TRIP, $this->CITY_TRIP]
                );

        $this->detailList =
            $this->account === 'null'
                ? []
                : Pok::where('pakai', true)->itemList(
                    explode('.', $this->output)[0],
                    explode('.', $this->output)[2],
                    explode('.', $this->account)[0],
                    explode('.', $this->account)[1],
                    explode('.', $this->account)[2]
                );

        $this->availableVolume =
            $this->detail === 'null'
                ? 0
                : Pok::where('pakai', true)->where('id', $this->detail)->pluck('volume')[0] -
                  AlokasiPerjalananDinas::where('pok_id', $this->detail)->sum('total');

        $this->availableBudget =
            $this->detail === 'null'
                ? 0
                : number_format(
                    Pok::where('pakai', true)->where('id', $this->detail)->pluck('total')[0], 0, ',', '.'
                );

        $this->measure =
            $this->detail === 'null'
                ? '-'
                : Pok::where('pakai', true)->where('id', $this->detail)->pluck('satuan')[0];

        return view('livewire.management.trip-allocation.create-allocation');
    }

    public function addRow()
    {
        $this->tripAllocationList[] = [];
    }

    public function deleteRow($index)
    {
        unset($this->tripAllocationList[$index]);

        array_values($this->tripAllocationList);
    }

    public function save(TripAllocationRepository $tripAllocationRepository)
    {
        $result = $tripAllocationRepository->store($this);

        session()->flash('message', $result);

        return redirect(env('APP_URL') . 'tata-kelola/alokasi-perjalanan-dinas');
    }
}
