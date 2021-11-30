<?php

namespace App\Repositories;

use App\Jobs\KirimNotifikasiTelegram;
use App\Models\Berkas;
use App\Models\DetailPerjalananDinas;
use App\Models\Lembur;
use App\Models\PaketMeeting;
use App\Models\PerjalananDinas;
use App\Models\TindakLanjut;
use App\Traits\HasTelegram;
use App\Traits\ThrowMessageable;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class FollowUpRepository
{
    use HasTelegram, ThrowMessageable;

    public function followup(string $reference_id, string $unit, int $status) : array
    {
        DB::beginTransaction();

        try
        {
            $status_type = $this->getStatusName($unit);

            if ($status == 0) {
                TindakLanjut::where('reference_id', $reference_id)->update([$status_type[0] => 1, $status_type[1] => Carbon::now()]);

                $type = [
                    'PM' => [PaketMeeting::where('reference_id', $reference_id)->first('user_id')->user_id, 'Paket Meeting'],
                    'LB' => [Lembur::where('reference_id', $reference_id)->first('user_id')->user_id, 'Lembur'],
                    'PD' => [PerjalananDinas::where('reference_id', $reference_id)->first('user_id')->user_id, 'Perjalanan Dinas']
                ][explode('-', $reference_id)[0]];

                $telegramId = $this->getTelegramId($type[0]);

                is_null($telegramId) ?:
                    KirimNotifikasiTelegram::dispatch(
                        $telegramId,
                        "Pengajuan Belanja " . $type[1] . " Nomor : " . $reference_id . ", Telah Ditindaklanjuti Oleh " . $unit .
                        " Terima kasih."
                    );
            } else {
                TindakLanjut::where('reference_id', $reference_id)->update([$status_type[0] => 0, $status_type[1] => null]);
            }

            $message = $this->success('followup', "Tindak Lanjut Pengajuan Kegiatan Kode " . $reference_id . " Telah Diperbaharui, Terima Kasih.");

            DB::commit();
        } catch (Exception $error) {
            DB::rollBack();

            $message = $this->fail('followup', $error, "Informasi Tindak Lanjut Gagal Disimpan, Silahkan Hubungi Administrator.");
        }

        return $message;
    }

    public function getCountData($unit) : array
    {
        $status_name = $this->getStatusName($unit)[0];

        $query = TindakLanjut::query();

        $query->when($unit === 'kepeghum' || $unit === 'pengadaan-barjas', function ($q) use ($status_name) {
            return $q->select($status_name, DB::raw('count (' . $status_name. ') as total'))
                     ->where('reference_id', 'like', 'PM%')
                     ->groupBy($status_name)
                     ->orderBy($status_name, 'asc');
        })->when($unit === 'keuangan', function ($q) use ($status_name) {
            return $q->select($status_name, DB::raw('count (' . $status_name . ') as total'))
                     ->groupBy($status_name)
                     ->orderBy($status_name, 'asc');
        });

        $data = $query->get();

        $result[0] = count($data->where($status_name, 0)) == 0 ? 0 : array_values($data->where($status_name, 0)->toArray())[0]['total'];
        $result[1] = count($data->where($status_name, 1)) == 0 ? 0 : array_values($data->where($status_name, 1)->toArray())[0]['total'];

        return $result;
    }

    public function getData($unit, $status) : Collection
    {
        $status_name = $this->getStatusName($unit)[0];

        $query = TindakLanjut::query();

        $query->when($unit === 'kepeghum' || $unit === 'pengadaan-barjas', function ($q) use ($status, $status_name) {
            return $q->where($status_name, $status)
                     ->where('reference_id', 'like', 'PM%')
                     ->orderBy('tanggal_dibuat', 'desc');
        })->when($unit === 'keuangan', function ($q) use($status, $status_name) {
            return $q->where($status_name, $status)
                     ->orderBy('tanggal_dibuat', 'desc');
        });

        return $query->get();
    }

    private function getStatusName($unit) : array
    {
        return [
            'kepeghum'         => ['status_kepegawaian', 'tgl_followup_kepegawaian'],
            'keuangan'         => ['status_keuangan', 'tgl_followup_keuangan'],
            'pengadaan-barjas' => ['status_barjas', 'tgl_followup_barjas']
        ][$unit];
    }
}
