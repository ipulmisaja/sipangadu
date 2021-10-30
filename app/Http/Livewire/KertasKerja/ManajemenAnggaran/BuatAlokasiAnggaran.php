<?php

namespace App\Http\Livewire\KertasKerja\ManajemenAnggaran;

use App\Models\Unit;
use App\Models\Pok;
use Livewire\Component;

class BuatAlokasiAnggaran extends Component
{
    /** @var collection */
    public $activityList;

    /** @var array */
    public $func_coord;

    public function render()
    {
        $this->activityList = Pok::kegiatan();

        return view('livewire.kertas-kerja.manajemen-anggaran.buat-alokasi-anggaran', [
            'list_kf'  => Unit::where('parent', 1)->get(['id', 'nama']),
            'list_skf' => Unit::where('parent', '>', 1)->get(['id', 'nama'])
        ]);
    }
}
