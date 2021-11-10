<?php

namespace App\Repositories;

use App\Jobs\KirimNotifikasiTelegram;
use App\Models\Berkas;
use App\Models\PaketMeeting;
use App\Models\Payment;
use App\Models\Pemeriksaan;
use App\Models\TindakLanjut;
use App\Models\Unit;
use App\Traits\Commentable;
use App\Traits\GDriveUploadable;
use App\Traits\HasTelegram;
use App\Traits\UserIdTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaketMeetingRepository
{
    use Commentable, GDriveUploadable, HasTelegram, UserIdTrait;

    public function store($data) : string
    {
        try {
            DB::beginTransaction();

            $drivePath = $this->uploadFile(env('GOOGLE_DRIVE_FOLDER_BELANJA'), $data->file);

            $paketMeeting = PaketMeeting::create([
                'tanggal_pengajuan' => Carbon::parse($data->tanggal_pengajuan, 'UTC'),
                'nomor_pengajuan'   => $data->nota_dinas,
                'nama'              => $data->nama_kegiatan,
                'pok_id'            => $data->detail,
                'total'             => $data->budget,
                'volume'            => $data->volume,
                'file'              => $drivePath['basename'],
                'catatan'           => $data->catatan ?? null,
                'user_id'           => Auth::user()->id
            ]);

            $pemeriksaan = Pemeriksaan::create([
                'user_id'           => Auth::user()->id,
                'reference_id'      => $paketMeeting->reference_id,
                'tanggal_pengajuan' => $paketMeeting->tanggal_pengajuan
            ]);


            $message = 'Informasi paket meeting telah disimpan.';

            $telegramId = $this->getParentTelegramId($pemeriksaan);

            is_null($telegramId) ?:
                KirimNotifikasiTelegram::dispatch(
                    $telegramId,
                    "Pengajuan belanja " . $paketMeeting->nama . " telah dibuat oleh " .
                    Auth::user()->nama . ". Mohon dilakukan pemeriksaan, terima kasih."
                );

            DB::commit();
        } catch(Exception $error) {
            DB::rollBack();

            $this->deleteFile($drivePath['basename']);

            Log::alert($error->getMessage());

            $message = 'Informasi paket meeting gagal disimpan.';
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

                    $data->activity->update([
                        'approve_kf'         => $data->approval_state,
                        'tanggal_approve_kf' => Carbon::now()
                    ]);

                    $this->setComment($data->activity, $data->approval_state, $data->comment, $role);

                    if ($data->approval_state == 1) {
                        $binagram   = $this->getUserIdByRole('binagram');

                        $telegramId = $this->getTelegramId($binagram);

                        is_null($telegramId) ?:
                            KirimNotifikasiTelegram::dispatch(
                                $telegramId,
                                "Pengajuan belanja " . $data->activity->paketMeetingRelationship->nama . " telah diperiksa oleh koordinator fungsi/kepala bidang." .
                                "\n\nMohon diperiksa kembali, terima kasih."
                            );
                    } elseif ($data->approval_state == 2) {
                        $telegramId = $this->getTelegramId($data->activity->user_id);

                        is_null($telegramId) ?:
                            KirimNotifikasiTelegram::dispatch(
                                $telegramId,
                                "Pengajuan belanja " . $data->activity->paketMeetingRelationship->nama . " ditolak oleh koordinator fungsi/kepala bidang." .
                                "\n\nMohon lakukan perbaikan, terima kasih."
                            );
                    } else {}

                    DB::commit();
                } catch(Exception $error) {
                    DB::rollBack();

                    Log::alert($error->getMessage());
                }

                break;
            case 'binagram' :
                try {
                    DB::beginTransaction();

                    $data->activity->update([
                        'approve_binagram'         => $data->approval_state,
                        'tanggal_approve_binagram' => Carbon::now()
                    ]);

                    $this->setComment($data->activity, $data->approval_state, $data->comment, $role);

                    if ($data->approval_state > 0) {
                        $ppk = $this->getUserIdByRole('ppk');

                        $telegramId = $this->getTelegramId($ppk);

                        is_null($telegramId) ?:
                            KirimNotifikasiTelegram::dispatch(
                                $telegramId,
                                "Pengajuan belanja " . $data->activity->paketMeetingRelationship->nama . " telah diperiksa oleh SKF Perencana." .
                                "\n\nMohon diperiksa kembali, terima kasih."
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

                    $data->activity->update([
                        'approve_ppk'         => $data->approval_state,
                        'tanggal_approve_ppk' => Carbon::now()
                    ]);

                    $this->setComment($data->activity, $data->approval_state, $data->comment, $role);

                    if ($data->approval_state == 1) {
                        $telegramId = $this->getTelegramId($data->activity->user_id);

                        is_null($telegramId) ?:
                            KirimNotifikasiTelegram::dispatch(
                                $telegramId,
                                "Pengajuan belanja " . $data->activity->paketMeetingRelationship->nama . " disetujui oleh PPK."
                            );


                        $kepeghumTelegramId = $this->getUserIdByUnit('kepeghum');

                        is_null($kepeghumTelegramId) ?:
                            KirimNotifikasiTelegram::dispatch(
                                $kepeghumTelegramId,
                                "Pengajuan belanja " . $data->activity->paketMeetingRelationship->nama . " telah disetujui PPK. Mohon dapat ditindaklanjuti, terima kasih."
                            );

                        $keuanganTelegramId = $this->getUserIdByUnit('keuangan');

                        is_null($keuanganTelegramId) ?:
                            KirimNotifikasiTelegram::dispatch(
                                $keuanganTelegramId,
                                "Pengajuan belanja " . $data->activity->paketMeetingRelationship->nama . " telah disetujui PPK. Mohon dapat ditindaklanjuti, terima kasih."
                            );

                        $barjasTelegramId   = $this->getUserIdByUnit('pengadaan-barjas');

                        is_null($barjasTelegramId) ?:
                            KirimNotifikasiTelegram::dispatch(
                                $barjasTelegramId,
                                "Pengajuan belanja " . $data->activity->paketMeetingRelationship->nama . " telah disetujui PPK. Mohon dapat ditindaklanjuti, terima kasih."
                            );

                        $data->activity->update(['approve' => 1]);

                        TindakLanjut::create([
                            'reference_id'   => $data->activity->reference_id,
                            'tanggal_dibuat' => Carbon::now()
                        ]);

                        Berkas::create([
                            'reference_id' => $data->activity->reference_id,
                            'user_id'      => $data->activity->user_id
                        ]);
                    } elseif ($data->approval_state == 2) {
                        $data->activity->update(['approve' => 2]);
                        $telegramId = $this->getTelegramId($data->activity->user_id);

                        is_null($telegramId) ?:
                            KirimNotifikasiTelegram::dispatch(
                                $telegramId,
                                "Pengajuan belanja " . $data->activity->paketMeetingRelationship->nama . " ditolak oleh PPK." .
                                "\n\nMohon lakukan perbaikan, terima kasih."
                            );
                    }

                    DB::commit();
                } catch(Exception $error) {
                    DB::rollBack();

                    Log::alert($error->getMessage());
                }
                break;
        }
    }
}
