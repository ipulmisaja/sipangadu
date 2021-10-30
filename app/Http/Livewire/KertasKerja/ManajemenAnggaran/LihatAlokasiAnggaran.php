<?php

namespace App\Http\Livewire\KertasKerja\ManajemenAnggaran;

use App\Models\Pok;
use Livewire\Component;

class LihatAlokasiAnggaran extends Component
{
    public $year;
    public $listYear;
    public $listPokAllocation;

    public function mount()
    {
        $this->listPokAllocation =
            Pok::with('unit')
               -> where('pakai', true)
               -> whereNotNull('unit_id')
               -> where('kd_kro', '000')
               -> orderBy('unit_id', 'asc')
               -> get([
                   'tahun', 'kd_departemen', 'kd_organisasi', 'kd_program', 'kd_kegiatan',
                   'deskripsi', 'unit_id', 'total'
               ]);
    }

    public function updatedYear($val)
    {
        $this->listPokAllocation =
           $val === 'last'
                ? Pok::with('unit')
                    -> where('pakai', true)
                    -> whereNotNull('unit_id')
                    -> where('kd_kro', '000')
                    -> orderBy('unit_id', 'asc')
                    -> get([
                        'tahun', 'kd_departemen', 'kd_organisasi', 'kd_program', 'kd_kegiatan',
                        'deskripsi', 'unit_id', 'total', 'revisi'
                    ])
                : Pok::with('unit')
                    -> where('tahun', $val)
                    -> where('revisi', Pok::where('tahun', $val)->max('revisi'))
                    -> whereNotNull('unit_id')
                    -> where('kd_kro', '000')
                    -> orderBy('unit_id', 'asc')
                    -> get([
                        'tahun', 'kd_departemen', 'kd_organisasi', 'kd_program', 'kd_kegiatan',
                        'deskripsi', 'unit_id', 'total', 'revisi'
                    ]);
    }

    public function render()
    {
        $this->listYear = Pok::distinct('tahun')->get('tahun');

        return view('livewire.kertas-kerja.manajemen-anggaran.lihat-alokasi-anggaran');
    }
}
