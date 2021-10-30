<?php

namespace App\Repositories\Setting;

use App\Models\Webhook;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WebhookRepository
{
    public function store($data) : string
    {
        try {
            DB::beginTransaction();

            Webhook::create([
                'aplikasi' => $data->application,
                'url'      => $data->url
            ]);

            $message = "Webhook telah disimpan.";

            DB::commit();
        } catch(Exception $error) {
            DB::rollBack();

            Log::alert($error->getMessage());

            $message = "Gagal menyimpan webhook.";
        }

        return $message;
    }

    public function update($data) : string
    {
        try {
            DB::beginTransaction();

            $data->webhook->update([
                'aplikasi' => $data->application,
                'url'      => $data->url,
                'status'   => false
            ]);

            $message = "Webhook telah diperbaharui.";

            DB::commit();
        } catch(Exception $error) {
            DB::rollBack();

            Log::alert($error->getMessage());

            $message = "Webhook gagal diperbaharui.";
        }

        return $message;
    }

    public function updateStatus($id) : string
    {
        $webhook = Webhook::where('id', $id)->first();

        $client  = new Client;

        try {
            DB::beginTransaction();

            // jika webhook dari berbagai penyedia aplikasi
            // perlu dilakukan pengecekan url
            // sementara hanya telegram saja
            if ($webhook->status) {
                $webhook->update(['status' => false]);

                $url = "https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/deletewebhook";

                $message = "Webhook telah dimatikan.";
            } else {
                $webhook->update(['status' => true]);

                $url = "https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/setwebhook?url=" . $webhook->url;

                $message = "Webhook telah diaktifkan.";
            }

            DB::commit();

            $client->get($url);
        } catch(Exception $error) {
            DB::rollBack();

            Log::alert($error->getMessage());

            $message = "Webhook gagal diaktifkan.";
        }

        return $message;
    }
}
