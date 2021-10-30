<?php

namespace App\Repositories;

use App\Models\Msm;
use App\Traits\Commentable;
use App\Traits\GDriveUploadable;
use App\Traits\HasTelegram;
use App\Traits\UserRoleTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MsmRepository
{
    use Commentable, GDriveUploadable, HasTelegram, UserRoleTrait;

    public function store($data) : string
    {
        try
        {
            DB::beginTransaction();

            $drivePath = !is_null($data->file)
                ? $this->uploadFile(env('GOOGLE_DRIVE_FOLDER_MSM'), $data->file)
                : null;

            $msm = Msm::create([
                'pok_id'            => $data->componentArrayStore,
                'user_id'           => Auth::user()->id,
                'catatan'           => $data->description,
                'file'              => $drivePath['basename'],
                'tanggal_pengajuan' => Carbon::now()
            ]);

            $message = "Terima kasih, usulan matriks semula menjadi anda telah disimpan.";

            $telegramId = $this->getParentTelegramId($msm);

            is_null($telegramId) ?:
                $this->sendTelegramMessage(
                    $telegramId,
                    "Pengajuan MSM telah dibuat oleh " . Auth::user()->nama .
                    " Mohon dilakukan pemeriksaan terlebih dahulu, terima kasih."
                );

            DB::commit();
        } catch(Exception $error) {
            DB::rollBack();

            is_null($drivePath) ?: $this->deleteFile($drivePath['basename']);

            Log::alert($error->getMessage());

            $message = "Maaf, usulan matriks semula menjadi anda gagal disimpan.";
        }

        return $message;
    }

    public function updateApproval(string $role, $data)
    {
        switch($role)
        {
            case 'koordinator' :
                try {
                    DB::beginTransaction();

                    $data->pok->update([
                        'approve_kf'         => $data->approval_state,
                        'tanggal_approve_kf' => Carbon::now()
                    ]);

                    $this->setComment($data->pok, $data->approval_state, $data->comment, $role);

                    if ($data->approval_state == 1) {
                        $binagram   = $this->getUserIdByRole('binagram');

                        $telegramId = $this->getTelegramId($binagram);

                        is_null($telegramId) ?:
                            $this->sendTelegramMessage(
                                $telegramId,
                                "Pengajuan MSM telah diperiksan oleh koordinator fungsi yang bersangkutan." .
                                "\n\nMohon lakukan pemeriksaan kembali, terima kasih."
                            );
                    } elseif ($data->approval_state == 2) {
                        $telegramId = $this->getTelegramId($data->pok->user_id);

                        is_null($telegramId) ?:
                            $this->sendTelegramMessage(
                                $telegramId,
                                "Pengajuan MSM ditolak oleh koordinator fungsi." .
                                "\n\nMohon lakukan perbaikan, terima kasih."
                            );
                    }

                    DB::commit();
                } catch(Exception $error) {
                    DB::rollBack();

                    Log::alert($error->getMessage());
                }

                break;
            case 'binagram' :
                try {
                    DB::beginTransaction();

                    $data->pok->update([
                        'approve_binagram'         => $data->approval_state,
                        'tanggal_approve_binagram' => Carbon::now()
                    ]);

                    $this->setComment($data->pok, $data->approval_state, $data->comment, $role);

                    if ($data->approval_state > 0) {
                        $ppk = $this->getUserIdByRole('ppk');

                        $telegramId = $this->getTelegramId($ppk);

                        is_null($telegramId) ?:
                            $this->sendTelegramMessage(
                                $telegramId,
                                "Pengajuan MSM telah diberikan rekomendasi oleh fungsi perencana." .
                                "\n\nMohon lakukan pemeriksaan kembali, terima kasih."
                            );
                    }

                    DB::commit();
                } catch(Exception $error) {
                    DB::rollBack();

                    Log::alert($error->getMessage());
                }
                break;
            case 'ppk':
                try {
                    DB::beginTransaction();

                    $data->pok->update([
                        'approve_ppk'         => $data->approval_state,
                        'tanggal_approve_ppk' => Carbon::now()
                    ]);

                    $this->setComment($data->pok, $data->approval_state, $data->comment, $role);

                    $telegramId = $this->getTelegramId($data->pok->user_id);

                    if ($data->approval_state == 1) {
                        is_null($telegramId) ?:
                            $this->sendTelegramMessage(
                                $telegramId,
                                "Pengajuan MSM disetujui oleh ppk."
                            );
                    } elseif ($data->approval_state == 2) {
                        is_null($telegramId) ?:
                            $this->sendTelegramMessage(
                                $telegramId,
                                "Pengajuan MSM ditolak oleh ppk."
                            );
                    }

                    DB::commit();
                } catch(Exception $error) {
                    DB::rollBack();

                    Log::alert($error->getMessage());
                }
                break;
            default:
        }
    }
}
