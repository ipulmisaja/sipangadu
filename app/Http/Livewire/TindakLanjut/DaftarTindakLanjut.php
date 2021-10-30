<?php

namespace App\Http\Livewire\TindakLanjut;

use App\Models\TindakLanjut;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarTindakLanjut extends Component
{
    use WithPagination;

    public $tindakLanjut;

    public function mount($unit)
    {
        switch($unit) {
            case "kepeghum":
                $this->tindakLanjut =
                    TindakLanjut::query()
                        -> where('reference_id', 'like', 'PM%')
                        -> orderBy('tanggal_dibuat', 'desc')
                        -> get();
                break;
            case "keuangan":
                $this->tindakLanjut =
                    TindakLanjut::query()
                        -> orderBy('tanggal_dibuat', 'desc')
                        -> get();

                break;
            case "umum":
                break;
            case "pengadaan-barjas":
                $this->tindakLanjut =
                    TindakLanjut::query()
                        -> where('reference_id', 'like', 'PM%')
                        -> orderBy('tanggal_dibuat', 'desc')
                        -> get();

                break;
            default:
        }

    }

    public function render()
    {
        return view('livewire.tindak-lanjut.daftar-tindak-lanjut');
    }
}
