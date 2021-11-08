<?php

use App\Jobs\KirimNotifikasiTelegram;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::post('/bot/webhook', function() {
    $updates = json_decode(file_get_contents("php://input"));

    if (isset($updates->message))
    {
        $message = $updates->message;

        if (isset($message->text))
        {
            switch ($message->text)
            {
                case '/start' :
                    Log::info($message->chat->username);

                    $result = User::where('telegram_id', $message->chat->username);

                    if($result->count() == 1) {
                        // Pesan pertama setelah bot aktif
                        KirimNotifikasiTelegram::dispatch($message->chat->username, "Selamat Datang " . $result->first('nama')->nama);
                    } else {
                        // Pesan untuk melakukan verifikasi ID Telegram
                        $pesan = "Selamat Datang, verifikasi akun anda dengan mengetik <i>verifikasi#nip-bps#email-bps</i> untuk dapat menggunakan layanan SIPANGADU. \n\n Contoh : <b>verifikasi#340012345#pegawai76@bps.go.id</b>";

                        KirimNotifikasiTelegram::dispatch($message->chat->username, $pesan);
                    }
                    break;
                default :
                    $pesan = explode('#', $message->text);

                    if ($pesan[0] === 'verifikasi') {
                        $bps_id = $pesan[1];
                        $email  = $pesan[2];

                        $result = User::where('telegram_id', $message->chat->username)->first();

                        switch(is_null($result)) {
                            case true:
                                $result = User::where('bps_id', $bps_id)->where('email', $email)->first();

                                if(!is_null($result)) {
                                    $result->update([
                                        'telegram_id' => $message->chat->username
                                    ]);

                                    $pesan = "Telegram anda telah diverifikasi, selamat datang " . $result->nama . ".\nAnda dapat menggunakan layanan SIPANGADU yang beralamat di https://bpsprovsulbar.id/sipangadu/. \n\n Untuk mendapatkan username dan password sementara ketik <b>akun</b>.";

                                    KirimNotifikasiTelegram::dispatch($message->chat->username, $pesan);

                                } else {
                                    KirimNotifikasiTelegram::dispatch($message->chat->username, 'Data yang anda berikan tidak dapat diverifikasi, silahkan hubungi administrator.');
                                }

                                break;
                            case false:
                                if($result->email === $email && $result->bps_id === $bps_id) {
                                    KirimNotifikasiTelegram::dispatch($message->chat->username, 'Anda sudah melakukan verifikasi pada akun ini.');
                                } else {
                                    KirimNotifikasiTelegram::dispatch($message->chat->username, 'Anda tidak diperkenankan melakukan verifikasi lebih dari satu akun.');
                                }

                                break;
                        }
                    } elseif ($pesan[0] === 'akun') {
                        $result = User::where('telegram_id', $message->chat->username)->first();

                        $json = json_decode(File::get('database/data/user7600.json'));

                        $collection = collect($json);

                        $data = array_values($collection->where('bps_id', $result->bps_id)->toArray());

                        $pesan = "Username : " . $result->username . "\n" . "Password : " . $data[0]->password;

                        KirimNotifikasiTelegram::dispatch($message->chat->username, $pesan);

                    } else {}
            }
        }
    }
});
