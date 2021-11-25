<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Log;

trait ThrowMessageable
{
    public function success(string $type, string $message = null) : array
    {
        switch($type)
        {
            case 'store' :
                return [
                    'type'    => 'success',
                    'message' => 'Informasi Pengajuan Belanja Telah Disimpan, Terima Kasih.'
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
            case 'followup' :
                return [
                    'type'    => 'success',
                    'message' => $message
                ];
        }
    }

    public function fail(string $type, Exception $error, string $message = null) : array
    {
        Log::alert($error->getMessage());

        switch($type)
        {
            case 'store' :
                return [
                    'type'    => 'error',
                    'message' => 'Informasi Pengajuan Belanja Gagal Disimpan, Silahkan Hubungi Administrator.'
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
            case 'followup' :
                return [
                    'type'    => 'error',
                    'message' => $message
                ];

                break;
        }
    }
}
