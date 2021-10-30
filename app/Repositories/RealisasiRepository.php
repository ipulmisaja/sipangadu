<?php

namespace App\Repositories;

use App\Models\PencairanAnggaran;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RealisasiRepository
{
    public function store($data) : string
    {
        try {
            DB::beginTransaction();

            PencairanAnggaran::updateOrCreate(['reference_id' => $data->realisasi->reference_id ?? null], [
                'nama'     => $data->name ?? null,
                'pok_id'   => $data->realisasi->pok_id ?? $data->detail,
                'spm'      => $data->spmNumber,
                'spm_date' => Carbon::parse($data->spmDate, 'UTC'),
                'total'    => $data->total,
                'volume'   => $data->volume
            ]);

            $message = "Informasi entri realisasi telah disimpan.";

            DB::commit();
        } catch(Exception $error) {
            DB::rollBack();

            Log::alert($error->getMessage());

            $message = "Gagal menyimpan informasi entri realisasi.";
        }

        return $message;
    }
}
