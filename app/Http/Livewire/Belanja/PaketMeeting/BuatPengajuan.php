<?php

namespace App\Http\Livewire\Belanja\PaketMeeting;

use App\Models\Pok;
use App\Models\PencairanAnggaran;
use App\Repositories\PaketMeetingRepository;
use App\Traits\ValidasiBelanja;
use Ipulmisaja\Macoa\Helpers\InputMask;
use Livewire\Component;
use Livewire\WithFileUploads;

class BuatPengajuan extends Component
{
    use ValidasiBelanja, WithFileUploads;

    private $FULLBOARD_OFFLINE = '524114';
    private $FULLBOARD_ONLINE  = '521241';

    /** Pre Rendered Properties */
    public $outputList;
    public $accountList;
    public $detailList;
    public $availableBudget;
    public $availableVolume;
    public $satuan;

    public $tanggal_pengajuan;
    public $nota_dinas;
    public $nama_kegiatan;
    public $output = 'null';
    public $akun = 'null';
    public $detail = 'null';
    public $budget;
    public $volume;
    public $date;
    public $file;
    public $catatan;

    /** Model Property */
    public $fullboard;

    public function render()
    {
        $this->outputList = Pok::outputList('<>', '0000');

        $this->accountList =
            $this->output === 'null'
                ? []
                : Pok::detailList(
                    explode('.', $this->output)[0], // kd-kegiatan
                    explode('.', $this->output)[2], // kd-ro
                    [$this->FULLBOARD_OFFLINE, $this->FULLBOARD_ONLINE]
                );

        $this->detailList =
            $this->akun === 'null'
                ? []
                : Pok::itemList(
                    explode('.', $this->output)[0],
                    explode('.', $this->output)[2],
                    explode('.', $this->akun)[0],
                    explode('.', $this->akun)[1],
                    explode('.', $this->akun)[2]
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

        return view('livewire.belanja.paket-meeting.buat-pengajuan');
    }

    public function save(PaketMeetingRepository $paketMeetingRepository)
    {
        $temp = str_replace(".", "", $this->budget);

        $this->budget = intval($temp);

        $this->paketMeetingValidasi($this);

        $result = $paketMeetingRepository->store($this);

        session()->flash('message', $result);

        return redirect(env('APP_URL') . 'belanja/paket-meeting');
    }

    public function updatedBudget()
    {
        $this->budget = str_replace(".", "", $this->budget);

        if ($this->budget !== '') $this->budget = InputMask::mask($this->budget, number_format($this->budget, 0, ',', '.'));
    }
}
