<?php

namespace App\Http\Livewire\Berkas\Realisasi\Verifikasi;

use App\Models\PencairanAnggaran;
use App\Models\Pok;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class DaftarVerifikasi extends Component
{
    public $daftarVerifikasi;

    public function mount()
    {
        $this->daftarVerifikasi = PencairanAnggaran::whereNotNull('volume')->orWhereNotNull('total')->get();
    }

    public function verifikasi($id, $status)
    {
        $data = null;
        $data = PencairanAnggaran::findOrFail($id);

        try {
            DB::beginTransaction();

            if ($status === 'terima') {
                $data->update([
                    'approve_ppk' => 1,
                    'tanggal_approve_ppk' => Carbon::now()
                ]);

                Pok::where('id', $data['pok_id'])->first('total_realisasi')->total_realisasi == 0
                    ? Pok::where('id', $data['pok_id'])->update([
                        'volume_realisasi' => $data['volume'],
                        'total_realisasi'  => $data['total']
                      ])
                    : Pok::where('id', $data['pok_id'])->update([
                        'volume_realisasi' => Pok::where('id', $data['pok_id'])->first('volume_realisasi')->volume_realisasi + $data['volume'],
                        'total_realisasi'  => Pok::where('id', $data['pok_id'])->first('total_realisasi')->total_realisasi + $data['total']
                    ]);
            } else {
                $data->update([
                    'approve_ppk' => 2,
                    'tanggal_approve_ppk' => Carbon::now()
                ]);

                Pok::where('id', $data['pok_id'])->first('total_realisasi')->total_realisasi == 0
                    ?:  Pok::where('id', $data['pok_id'])->update([
                            'volume_realisasi' => Pok::where('id', $data['pok_id'])->first('volume_realisasi')->volume_realisasi - $data['volume'],
                            'total_realisasi'  => Pok::where('id', $data['pok_id'])->first('total_realisasi')->total_realisasi - $data['total']
                        ]);
            }

            DB::commit();
        } catch(Exception $error) {
            DB::rollBack();

            Log::error($error->getMessage());
        }
        
    }

    public function render()
    {
        return view('livewire.berkas.realisasi.verifikasi.daftar-verifikasi');
    }
}
