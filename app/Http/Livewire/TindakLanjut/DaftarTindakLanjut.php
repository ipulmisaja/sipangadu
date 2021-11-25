<?php

namespace App\Http\Livewire\TindakLanjut;

use App\Models\TindakLanjut;
use App\Repositories\FollowUpRepository;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarTindakLanjut extends Component
{
    use WithPagination;

    public $unit;
    public $jumlahTindakLanjut;
    public $tindakLanjut;
    public $status;

    public function mount(FollowUpRepository $followUpRepository, $unit)
    {
        $this->unit = $unit;

        $this->status = 'undone';

        $this->jumlahTindakLanjut = $followUpRepository->getCountData($unit);

        $this->tindakLanjut = $followUpRepository->getData($unit, 0);
    }

    public function render()
    {
        return view('livewire.tindak-lanjut.daftar-tindak-lanjut');
    }

    public function undone(FollowUpRepository $followUpRepository)
    {
        $this->resetPage();

        $this->status = 'undone';

        $this->jumlahTindakLanjut = $followUpRepository->getCountData($this->unit);

        $this->tindakLanjut = $followUpRepository->getData($this->unit, 0);
    }

    public function done(FollowUpRepository $followUpRepository)
    {
        $this->resetPage();

        $this->status = 'done';

        $this->jumlahTindakLanjut = $followUpRepository->getCountData($this->unit);

        $this->tindakLanjut = $followUpRepository->getData($this->unit, 1);
    }

    public function followup(FollowUpRepository $followUpRepository, string $reference_id, int $status, string $unit)
    {
        $result = $followUpRepository->followup($reference_id, $unit, $status);

        session()->flash($result['type'], $result['message']);

        return redirect(env('APP_URL') . 'tindak-lanjut/' . $unit);
    }
}
