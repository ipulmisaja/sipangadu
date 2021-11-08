<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Telegram\Bot\Laravel\Facades\Telegram;

class KirimNotifikasiTelegram implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $telegramId;
    public $pesan;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($telegramId, $pesan)
    {
        $this->telegramId = $telegramId;

        $this->pesan = $pesan;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Telegram::sendMessage([
            'chat_id'    => $this->telegramId,
            'parse_mode' => 'html',
            'text'       => $this->pesan
        ]);
    }
}
