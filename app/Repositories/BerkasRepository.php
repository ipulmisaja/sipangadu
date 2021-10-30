<?php

namespace App\Repositories;

use App\Models\PencairanAnggaran;
use App\Traits\GDriveUploadable;
use App\Traits\HasTelegram;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class BerkasRepository
{
    use GDriveUploadable, HasTelegram;

    private $directoryId;

    public function store($data) : string
    {
        try {
            DB::beginTransaction();

            $oldPath = $data->berkas->file;

            is_null($oldPath) ?: $this->deleteFile($oldPath);

            switch(getModelRelationship($data->berkas->reference_id)['abbreviation'])
            {
                case 'PM' :
                    $this->directoryId = env('GOOGLE_DRIVE_FOLDER_BERKAS_PAKET_MEETING');
                    break;
                case 'LB' :
                    $this->directoryId = env('GOOGLE_DRIVE_FOLDER_BERKAS_LEMBUR');
                    break;
                case 'PD' :
                    $this->directoryId = env('GOOGLE_DRIVE_FOLDER_BERKAS_PERJADIN');
                    break;
            }

            $drivePath = $this->uploadFile($this->directoryId, $data->file);

            $data->berkas->update([
                'file'                => $drivePath['basename'],
                'catatan_file'        => $data->fileNote ?? null,
                'verifikasi'          => 0,
                'verifikator'         => null,
                'catatan_verifikator' => null,
            ]);

            $message = "Berkas telah diunggah.";

            DB::commit();
        } catch(Exception $error) {
            DB::rollBack();

            Log::alert($error->getMessage());

            $this->deleteFile($drivePath['basename']);

            $message = "Berkas gagal diunggah.";
        }
        return $message;
    }

    public function verification($data) : string
    {
        try {
            DB::beginTransaction();

            $data->verifikasi->update([
                'verifikasi'          => $data->statusVerifikasi,
                'verifikator'         => Auth::user()->id,
                'catatan_verifikator' => $data->catatanVerifikasi,
                'has_collect'         => $data->hasCollect
            ]);

            $relation = getModelRelationship($data->verifikasi->reference_id)['relationship'];

            if ($data->verifikasi->$relation->count() === $data->verifikasi->where('reference_id', $data->verifikasi->reference_id)->where('verifikasi', 1)->count()) {
                if ($data->hasCollect) {
                    PencairanAnggaran::create([
                        'reference_id' => $data->verifikasi->reference_id,
                        'pok_id'       => $data->verifikasi->$relation->pok_id
                    ]);
                } else {
                    // is_null($data->verifikasi->userRelationship->telegram_id) ?:
                    //     $this->sendTelegramMessage(
                    //         $data->verifikasi->userRelationship->telegram_id,
                    //         "Halo " . $data->verifikasi->userRelationship->name . ", berkas untuk pencairan kegiatan "
                    //         . $data->verifikasi->$relation->name . ".\ntelah diverifikasi. Mohon bukti fisik kegiatan dikumpulkan juga, terima kasih."
                    //     );
                }
            } elseif ($data->statusVerifikasi == 2) {
                // is_null($data->verifikasi->userRelationship->telegram_id) ?:
                //     $this->sendTelegramMessage(
                //         $data->verifikasi->userRelationship->telegram_id,
                //         "Halo " . $data->verifikasi->userRelationship->name . ", berkas untuk pencairan kegiatan "
                //         . $data->verifikasi->$relation->name . ".\ntidak lengkap. Silahkan unggah ulang berkas yang lengkap secepatnya, terima kasih."
                //     );
            }

            $message = "Verifikasi berkas telah dilakukan.";

            DB::commit();
        } catch(Exception $error) {
            DB::rollBack();

            Log::alert($error->getMessage());

            $message = "Verifikasi berkas gagal dilakukan.";
        }

        return $message;
    }
}
