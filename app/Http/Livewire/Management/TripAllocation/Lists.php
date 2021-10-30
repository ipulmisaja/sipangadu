<?php

namespace App\Http\Livewire\Management\TripAllocation;

use App\Models\Pok;
use App\Models\AlokasiPerjalananDinas;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Lists extends Component
{
    use WithPagination;

    public $view = 1;
    public $tripAllocationList;
    public $tripVolumeList;
    public $tripEmployeeList;

    public function mount()
    {
        $this->tripVolumeList =
            Pok::query()
                -> with('unit')
                -> where(function($q) {
                        $q->where('kd_akun', '524113')
                          ->where('kd_detail', '<>', 0);
                })
                -> orWhere(function($q) {
                        $q->where('kd_akun', '524111')
                          ->where('kd_detail', '<>', 0);
                })
                -> orderBy('tahun', 'desc')
                -> orderBy('unit_id', 'asc')
                -> get();

        $this->tripAllocationList =
            AlokasiPerjalananDinas::with(['userRelationship', 'pokRelationship'])->orderBy('pok_id', 'asc')->get();

        $this->tripEmployeeList =
            User::with('alokasiPerjadinRelationship')->orderBy('id', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.management.trip-allocation.lists');
    }
}
