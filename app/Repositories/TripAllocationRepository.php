<?php

namespace App\Repositories;

use App\Models\Pok;
use App\Models\AlokasiPerjalananDinas;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TripAllocationRepository
{
    public function store($data) : string
    {
        try {
            DB::beginTransaction();

            foreach($data->tripAllocationList as $item) {
                AlokasiPerjalananDinas::create([
                    'tahun'    => Pok::where('id', $data->detail)->pluck('tahun')[0],
                    'pok_id'  => $data->detail,
                    'user_id' => $item['employee'],
                    'total'   => $item['total']
                ]);
            }

            $message = "Data alokasi perjalanan dinas telah disimpan.";

            DB::commit();
        } catch(Exception $error) {
            DB::rollBack();

            Log::alert($error->getMessage());

            $message = "Gagal menyimpan data alokasi perjalanan dinas.";
        }

        return $message;
    }
}
