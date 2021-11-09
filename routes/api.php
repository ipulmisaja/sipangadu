<?php

use App\Jobs\KirimNotifikasiTelegram;
use App\Models\User;
use Illuminate\Support\Facades\File;
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
                    $result = User::where('telegram_id', $message->from->id);

                    if($result->count() == 1) {
                        // Pesan pertama setelah bot aktif
                        KirimNotifikasiTelegram::dispatch($message->from->id, "Selamat Datang " . $result->first('nama')->nama);
                    } else {
                        // Pesan untuk melakukan verifikasi ID Telegram
                        $pesan = "Selamat Datang, verifikasi akun anda dengan mengetik <i>verifikasi#nip_bps#email_bps</i> untuk dapat menggunakan layanan SIPANGADU.
                                 \n\n Contoh : <b>verifikasi#340012345#admin@bps.go.id</b>";

                        KirimNotifikasiTelegram::dispatch($message->from->id, $pesan);
                    }
                    break;
                default :
                    $pesan = explode('#', $message->text);

                    if ($pesan[0] === 'verifikasi') {
                        $idBps = $pesan[1];
                        $email = $pesan[2];

                        $result = User::where('telegram_id', $message->from->id)->first();

                        switch(is_null($result)) {
                            case true:
                                $query = User::where('bps_id', $idBps)->where('email', $email)->first();

                                if(!is_null($query)) {
                                    if (is_null($query->telegram_id)) {
                                        $query->update([
                                            'telegram_id' => $message->from->id
                                        ]);

                                        $pesan = "Akun anda telah diverifikasi, selamat datang " . $query->nama .
                                                ".\nAnda dapat menggunakan layanan SIPANGADU yang beralamat di https://bpsprovsulbar.id/sipangadu/.
                                                \n\n Untuk mendapatkan username dan password sementara ketik <b>akun</b>.";

                                        KirimNotifikasiTelegram::dispatch($message->from->id, $pesan);
                                    } else {
                                        KirimNotifikasiTelegram::dispatch(
                                            $message->from->id,
                                            "Data yang anda berikan sudah pernah diverifikasi."
                                        );
                                    }
                                } else {
                                    KirimNotifikasiTelegram::dispatch(
                                        $message->from->id,
                                        'Data anda tidak ada di dalam sistem kami, silahkan hubungi administrator.'
                                    );
                                }

                                break;
                            case false:
                                if($result->bps_id === $idBps && $result->email === $email) {
                                    KirimNotifikasiTelegram::dispatch(
                                        $message->from->id,
                                        'Data yang anda berikan sudah pernah diverifikasi.'
                                    );
                                } else {
                                    KirimNotifikasiTelegram::dispatch(
                                        $message->from->id,
                                        'Anda tidak diperkenankan melakukan verifikasi lebih dari satu akun.'
                                    );
                                }

                                break;
                        }
                    } elseif ($pesan[0] === 'akun') {
                        $result = User::where('telegram_id', $message->from->id)->first();

                        $json = json_decode(File::get('database/data/user7600.json'));

                        $collection = collect($json);

                        $data = array_values($collection->where('bps_id', $result->bps_id)->toArray());

                        $pesan = "Username : " . $result->username . "\n" . "Password : " . $data[0]->password;

                        KirimNotifikasiTelegram::dispatch($message->from->id, $pesan);

                    } else {}
            }
        }
    }
});
