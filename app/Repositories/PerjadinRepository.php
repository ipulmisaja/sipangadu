<?php

namespace App\Repositories;

use App\Jobs\KirimNotifikasiTelegram;
use App\Models\DetailPerjalananDinas;
use App\Models\Berkas;
use App\Models\Pemeriksaan;
use App\Models\PerjalananDinas;
use App\Models\TindakLanjut;
use App\Models\Unit;
use App\Traits\Commentable;
use App\Traits\HasTelegram;
use App\Traits\UserIdTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PerjadinRepository
{
    use Commentable, HasTelegram, UserIdTrait;

    public function store($data) : string
    {
        try {
            DB::beginTransaction();

            $perjadin = PerjalananDinas::create([
                'tanggal_pengajuan' => Carbon::parse($data->tanggal_pengajuan, 'UTC'),
                'nomor_pengajuan'   => $data->nota_dinas,
                'nama'              => $data->nama_kegiatan,
                'pok_id'            => $data->detail,
                'total'             => $data->budget,
                'volume'            => $data->volume,
                'catatan'           => $data->catatan ?? null
            ]);

            foreach($data->tripList as $item) {
                DetailPerjalananDinas::create([
                    'perjadin_id'       => $perjadin->id,
                    'user_id'           => $item['employee'],
                    'tujuan'            => $item['destination'],
                    'tanggal_berangkat' => Carbon::parse(explode('to', $item['tripdate'])[0], 'UTC'),
                    'tanggal_kembali'   => count(explode('to', $item['tripdate'])) > 1
                                        ? Carbon::parse(explode('to', $item['tripdate'])[1], 'UTC')
                                        : Carbon::parse(explode('to', $item['tripdate'])[0], 'UTC'),
                ]);
            }

            $pemeriksaan = Pemeriksaan::create([
                'user_id'           => Auth::user()->id,
                'reference_id'      => $perjadin->reference_id,
                'tanggal_pengajuan' => $perjadin->tanggal_pengajuan
            ]);

            $telegramId = $this->getParentTelegramId($pemeriksaan);

            is_null($telegramId) ?:
                KirimNotifikasiTelegram::dispatch(
                    $telegramId,
                    "Pengajuan belanja " . $perjadin->nama . " telah dibuat oleh " .
                    Auth::user()->name . ". Mohon dilakukan pemeriksaan, terima kasih."
                );

            $message = 'Informasi perjalanan dinas telah disimpan.';

            DB::commit();
        } catch(Exception $error) {
            DB::rollBack();

            Log::alert($error->getMessage());

            $message = 'Informasi perjalanan dinas gagal disimpan.';
        }

        return $message;
    }

    public function updateApproval(string $role, $data) : string
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
                                "Pengajuan belanja " . $data->activity->perjadinRelationship->nama . " telah diperiksa oleh koordinator fungsi/kepala bidang." .
                                "\n\nMohon diperiksa kembali, terima kasih."
                            );
                    } elseif ($data->approval_state == 2) {
                        $telegramId = $this->getTelegramId($data->activity->user_id);

                        is_null($telegramId) ?:
                            KirimNotifikasiTelegram::dispatch(
                                $telegramId,
                                "Pengajuan belanja " . $data->activity->perjadinRelationship->nama . " ditolak oleh koordinator fungsi/kepala bidang." .
                                "\n\nMohon lakukan perbaikan, terima kasih."
                            );
                    }

                    $message = "Informasi pemeriksaan telah disimpan.";

                    DB::commit();
                } catch(Exception $error) {
                    DB::rollBack();

                    $message = "Informasi pemeriksaan gagal disimpan.";

                    Log::alert($error->getMessage());
                }

                return $message;

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
                                "Pengajuan belanja " . $data->activity->perjadinRelationship->nama . " telah diperiksa oleh SKF Perencana." .
                                "\n\nMohon diperiksa kembali, terima kasih."
                            );
                    }

                    $message = "Informasi pemeriksaan telah disimpan.";

                    DB::commit();
                } catch(Exception $error) {
                    DB::rollBack();

                    $message = "Informasi pemeriksaan gagal disimpan.";

                    Log::alert($error->getMessage());
                }

                return $message;

                break;
            case 'ppk':
                try {
                    DB::beginTransaction();

                    $data->activity->update([
                        'approve_ppk'         => $data->approval_state,
                        'tanggal_approve_ppk' => Carbon::now()
                    ]);

                    $this->setComment($data->activity, $data->approval_state, $data->comment, $role);

                    if ($data->approval_state > 0) {
                        $kpa = $this->getUserIdByRole('kpa');

                        $telegramId = $this->getTelegramId($kpa);

                        is_null($telegramId) ?:
                            KirimNotifikasiTelegram::dispatch(
                                $telegramId,
                                "Pengajuan belanja " . $data->activity->perjadinRelationship->nama . " telah diperiksa oleh PPK." .
                                "\n\nMohon diperiksa kembali, terima kasih."
                            );
                    }

                    $message = "Informasi pemeriksaan telah disimpan.";

                    DB::commit();
                } catch(Exception $error) {
                    DB::rollBack();

                    $message = "Informasi pemeriksaan gagal disimpan.";

                    Log::alert($error->getMessage());
                }

                return $message;

                break;
            case 'kpa':
                try {
                    DB::beginTransaction();

                    $data->activity->update([
                        'approve_kepala'         => $data->approval_state,
                        'tanggal_approve_kepala' => Carbon::now()
                    ]);

                    $this->setComment($data->activity, $data->approval_state, $data->comment, $role);

                    if ($data->approval_state == 1) {
                        $telegramId = $this->getTelegramId($data->activity->user_id);

                        is_null($telegramId) ?:
                            KirimNotifikasiTelegram::dispatch(
                                $telegramId,
                                "Pengajuan belanja " . $data->activity->perjadinRelationship->nama . " disetujui oleh Kepala BPS."
                            );

                        $keuanganTelegramId = $this->getUserIdByUnit('keuangan');

                        is_null($keuanganTelegramId) ?:
                            KirimNotifikasiTelegram::dispatch(
                                $keuanganTelegramId,
                                "Pengajuan belanja " . $data->activity->paketMeetingRelationship->nama . " telah disetujui Kepala BPS. Mohon dapat ditindaklanjuti, terima kasih."
                            );

                        $data->activity->update(['approve' => 1]);

                        TindakLanjut::create([
                            'reference_id'   => $data->activity->reference_id,
                            'tanggal_dibuat' => Carbon::now()
                        ]);

                        $tripDetail = DetailPerjalananDinas::where('perjadin_id', $data->activity->perjadinRelationship->id)->get();

                        foreach($tripDetail as $trip) {
                            // Pemberian Nomor Urut Surat Tugas
                            if(is_null(DetailPerjalananDinas::max('mail_number'))) {
                                $trip->update(['mail_number' => 1]);
                            } else {
                                $max = DetailPerjalananDinas::max('mail_number');
                                $trip->update(['mail_number' => $max + 1]);
                            }

                            Berkas::create([
                                'reference_id' => $data->activity->reference_id,
                                'user_id'      => $trip->user_id
                            ]);
                        }
                    } elseif ($data->approval_state == 2) {
                        $data->activity->update(['approve' => 2]);
                        $telegramId = $this->getTelegramId($data->activity->user_id);

                        is_null($telegramId) ?:
                            KirimNotifikasiTelegram::dispatch(
                                $telegramId,
                                "Pengajuan belanja " . $data->activity->perjadinRelationship->nama . " ditolak oleh Kepala BPS." .
                                "\n\nMohon lakukan perbaikan, terima kasih."
                            );
                    }

                    $message = "Informasi pemeriksaan telah disimpan.";

                    DB::commit();
                } catch(Exception $error) {
                    DB::rollBack();

                    $message = "Informasi pemeriksaan gagal disimpan.";

                    Log::alert($error->getMessage());
                }

                return $message;

                break;
            default:
        }
    }
}
