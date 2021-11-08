<?php

namespace App\Repositories;

// use App\Jobs\KirimNotifikasiTelegram;
use App\Models\DetailLembur;
use App\Models\Berkas;
use App\Models\Lembur;
use App\Models\Pemeriksaan;
use App\Models\Pok;
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

class LemburRepository
{
    use Commentable, HasTelegram, UserIdTrait;

    public function store($data) : string
    {
        try {
            DB::beginTransaction();

            $lembur = Lembur::create([
                'tanggal_pengajuan' => Carbon::parse($data->tanggal_pengajuan, 'UTC'),
                'nomor_pengajuan'   => $data->nota_dinas,
                'nama'              => $data->nama_kegiatan,
                'pok_id'            => Pok::where('kd_akun', '512211')->where('kd_detail', 1)->pluck('id')[0],
                'catatan'           => $data->catatan ?? null,
            ]);

            foreach($data->overtimeList as $item) {
                DetailLembur::create([
                    'lembur_id'        => $lembur->id,
                    'user_id'          => $item['employee'],
                    'deskripsi'        => $item['description'],
                    'tanggal_mulai'    => Carbon::parse($item['overtimeStart'], 'UTC'),
                    'tanggal_berakhir' => Carbon::parse($item['overtimeEnd'], 'UTC'),
                    'durasi'           => Carbon::parse($item['overtimeStart'], 'UTC')->diffInHours(Carbon::parse($item['overtimeEnd'], 'UTC'))
                ]);
            }

            $pemeriksaan = Pemeriksaan::create([
                'user_id'           => Auth::user()->id,
                'reference_id'      => $lembur->reference_id,
                'tanggal_pengajuan' => $lembur->tanggal_pengajuan
            ]);

            $message = 'Informasi lembur telah disimpan.';

            // $telegramId = $this->getParentTelegramId($pemeriksaan);

            // is_null($telegramId) ?:
            //     KirimNotifikasiTelegram::dispatch(
            //         $telegramId,
            //         "Pengajuan belanja " . $lembur->nama . " telah dibuat oleh " .
            //         Auth::user()->name . ". Mohon dilakukan pemeriksaan, terima kasih."
            //     );

            DB::commit();
        } catch(Exception $error) {
            DB::rollBack();

            Log::alert($error->getMessage());

            $message = 'Informasi lembur gagal disimpan.';
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
                        // $binagram   = $this->getUserIdByRole('binagram');

                        // $telegramId = $this->getTelegramId($binagram);

                        // is_null($telegramId) ?:
                        //     KirimNotifikasiTelegram::dispatch(
                        //         $telegramId,
                        //         "Pengajuan belanja " . $data->activity->lemburRelationship->nama . " telah diperiksa oleh koordinator fungsi/kepala bagian." .
                        //         "\n\nMohon diperiksa kembali, terima kasih."
                        //     );
                    } elseif ($data->approval_state == 2) {
                        // $telegramId = $this->getTelegramId($data->activity->user_id);

                        // is_null($telegramId) ?:
                        //     KirimNotifikasiTelegram::dispatch(
                        //         $telegramId,
                        //         "Pengajuan belanja " . $data->activity->lemburRelationship->nama . " ditolak oleh koordinator fungsi/kepala bagian." .
                        //         "\n\nMohon lakukan perbaikan, terima kasih."
                        //     );
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
                        // $ppk = $this->getUserIdByRole('ppk');

                        // $telegramId = $this->getTelegramId($ppk);

                        // is_null($telegramId) ?:
                        //     KirimNotifikasiTelegram::dispatch(
                        //         $telegramId,
                        //         "Pengajuan belanja " . $data->activity->lemburRelationship->nama . " telah diperiksa oleh SKF Perencana." .
                        //         "\n\nMohon diperiksa kembali, terima kasih."
                        //     );
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
                        // $sekretaris = $this->getUserIdByRole('sekretaris');

                        // $telegramId = $this->getTelegramId($sekretaris);

                        // is_null($telegramId) ?:
                        //     KirimNotifikasiTelegram::dispatch(
                        //         $telegramId,
                        //         "Pengajuan belanja " . $data->activity->lemburRelationship->nama . " telah diperiksa oleh PPK." .
                        //         "\n\nMohon entri nomor dan tanggal SPKL, terima kasih."
                        //     );
                    } elseif ($data->approval_state == 2) {
                        // $telegramId = $this->getTelegramId($data->activity->user_id);

                        // is_null($telegramId) ?:
                        //     KirimNotifikasiTelegram::dispatch(
                        //         $telegramId,
                        //         "Pengajuan belanja " . $data->activity->lemburRelationship->nama . " ditolak oleh PPK." .
                        //         "\n\nMohon lakukan perbaikan, terima kasih."
                        //     );
                    }

                    DB::commit();
                } catch(Exception $error) {
                    DB::rollBack();

                    Log::alert($error->getMessage());
                }

                break;
            case 'sekretaris':
                try {
                    DB::beginTransaction();

                    $data->activity->update([
                        'followup_sekretaris'         => 1,
                        'tanggal_followup_sekretaris' => Carbon::now()
                    ]);

                    $data->activity->lemburRelationship->update([
                        'nomor_spkl'   => $data->spklNumber,
                        'tanggal_spkl' => Carbon::parse($data->spklDate, 'UTC')
                    ]);

                    // $kpa = $this->getUserIdByRole('kpa');

                    // $telegramId = $this->getTelegramId($kpa);

                    // is_null($telegramId) ?:
                    //     KirimNotifikasiTelegram::dispatch(
                    //         $telegramId,
                    //         "Nomor SPKL pengajuan belanja " . $data->activity->lemburRelationship->nama . " telah diinput oleh sekretaris." .
                    //         "\n\nMohon diperiksa kembali, terima kasih."
                    //     );

                    DB::commit();
                } catch(Exception $error) {
                    DB::rollBack();

                    Log::alert($error->getMessage());
                }
            case 'kpa':
                try {
                    DB::beginTransaction();

                    $data->activity->update([
                        'approve_kepala'         => $data->approval_state,
                        'tanggal_approve_kepala' => Carbon::now()
                    ]);

                    $this->setComment($data->activity, $data->approval_state, $data->comment, $role);

                    if ($data->approval_state == 1) {
                        // $telegramId = $this->getTelegramId($data->activity->user_id);

                        // is_null($telegramId) ?:
                        //     KirimNotifikasiTelegram::dispatch(
                        //         $telegramId,
                        //         "Pengajuan belanja " . $data->activity->lemburRelationship->nama . " disetujui oleh Kepala BPS."
                        //     );

                        // $keuanganTelegramId = $this->getUserIdByUnit('keuangan');

                        // is_null($keuanganTelegramId) ?:
                        //     KirimNotifikasiTelegram::dispatch(
                        //         $keuanganTelegramId,
                        //         "Pengajuan belanja " . $data->activity->lemburRelationship->nama . " telah disetujui Kepala BPS. Mohon dapat ditindaklanjuti, terima kasih."
                        //     );

                        $data->activity->update(['approve' => 1]);

                        TindakLanjut::create([
                            'reference_id'   => $data->activity->reference_id,
                            'tanggal_dibuat' => Carbon::now()
                        ]);

                        Berkas::create([
                            'reference_id' => $data->activity->reference_id,
                            'user_id'     => $data->activity->user_id
                        ]);
                    } elseif($data->approval_state == 2) {
                        $data->activity->update(['approve' => 2]);
                        // $telegramId = $this->getTelegramId($data->activity->user_id);

                        // is_null($telegramId) ?:
                        //     KirimNotifikasiTelegram::dispatch(
                        //         $telegramId,
                        //         "Pengajuan belanja " . $data->activity->lemburRelationship->nama . " ditolak oleh Kepala BPS."
                        //     );
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
