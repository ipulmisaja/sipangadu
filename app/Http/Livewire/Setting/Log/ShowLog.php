<?php

namespace App\Http\Livewire\Setting\Log;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ShowLog extends Component
{
    public $content;

    public function mount($log)
    {
        try {
            if (file_exists(storage_path('logs/' . $log))) {
                // Inspired from github.com/haruncpi/laravel-log-viewer
                $pattern = "/^\[(?<date>.*)\]\s(?<env>\w+)\.(?<type>\w+):(?<message>.*)/m";

                $content = file_get_contents(storage_path('logs/' . $log));

                preg_match_all($pattern, $content, $matches, PREG_SET_ORDER, 0);

                $this->content = [];
                foreach ($matches as $match) {
                    $this->content[] = [
                        'timestamp' => $match['date'],
                        'env' => $match['env'],
                        'type' => $match['type'],
                        'message' => trim($match['message'])
                    ];
                }
            }
        } catch(Exception $error) {
            Log::info($error->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.setting.log.show-log');
    }
}
