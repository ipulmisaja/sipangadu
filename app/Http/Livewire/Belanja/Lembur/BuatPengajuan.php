<?php

namespace App\Http\Livewire\Belanja\Lembur;

use App\Models\Lembur;
use App\Models\User;
use App\Repositories\LemburRepository;
use App\Traits\ValidasiBelanja;
use Livewire\Component;

class BuatPengajuan extends Component
{
    use ValidasiBelanja;

    private $FORM_CODE = '512211';

    /** Pre Rendered Property */
    public $overtimeList = [];
    public $employees = [];

    /** Wire Model Properties */
    public $tanggal_pengajuan;
    public $nota_dinas;
    public $nama_kegiatan;
    public $catatan;

    public function mount()
    {
        $this->employees = User::orderBy('id', 'asc')->get();

        $this->overtimeList = [
            []
        ];
    }

    public function addRow()
    {
        $this->overtimeList[] = [];

        $this->dispatchBrowserEvent('flatpickr', []);
    }

    public function deleteRow($index)
    {
        unset($this->overtimeList[$index]);

        array_values($this->overtimeList);

        $this->dispatchBrowserEvent('flatpickr', []);
    }

    public function save(LemburRepository $lemburRepository)
    {
        $this->lemburValidasi($this);

        $result = $lemburRepository->store($this);

        session()->flash($result['type'], $result['message']);

        return redirect(env('APP_URL') . 'belanja/lembur');
    }

    public function render()
    {
        return view('livewire.belanja.lembur.buat-pengajuan');
    }
}
