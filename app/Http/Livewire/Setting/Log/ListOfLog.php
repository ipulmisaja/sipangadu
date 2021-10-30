<?php

namespace App\Http\Livewire\Setting\Log;

use Illuminate\Support\Facades\File;
use Livewire\Component;

class ListOfLog extends Component
{
    /** Log Property */
    public $logFiles;

    public function mount()
    {
        if (!file_exists(storage_path('logs'))) return [];

        $this->logFiles = File::files(storage_path('logs'));

        // Sort files by modified time DESC
        usort($this->logFiles, function ($a, $b) {
            return -1 * strcmp($a->getMTime(), $b->getMTime());
        });
    }

    public function render()
    {
        return view('livewire.setting.log.list-of-log');
    }
}
