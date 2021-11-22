<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Log;

trait ThrowMessageable
{
    public function success(string $type) : array
    {
        switch($type)
        {
            case 'store' :
                return [
                    'type'    => 'success',
                    'message' => 'Informasi Pengajuan Perjalanan Dinas Telah Disimpan, Terima Kasih.'
                ];

                break;
            case 'update' :
                break;
            case 'approval' :
                return [
                    'type'    => 'success',
                    'message' => 'Informasi Hasil Pemeriksaan Telah Disimpan, Terima Kasih.'
                ];

                break;
        }
    }

    public function fail(string $type, Exception $error) : array
    {
        Log::alert($error->getMessage());

        switch($type)
        {
            case 'store' :
                return [
                    'type' => 'error',
                    'message' => 'Informasi Pengajuan Perjalanan Dinas Gagal Disimpan, Silahkan Hubungi Administrator.'
                ];

                break;
            case 'update' :
                break;
            case 'approval' :
                return [
                    'type'    => 'error',
                    'message' => 'Informasi Hasil Pemeriksaan Gagal Disimpan, Silahkan Hubungi Administrator.'
                ];

                break;
        }
    }
}
