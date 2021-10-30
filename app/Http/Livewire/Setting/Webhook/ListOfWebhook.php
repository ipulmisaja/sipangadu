<?php

namespace App\Http\Livewire\Setting\Webhook;

use App\Models\Webhook;
use App\Repositories\Setting\WebhookRepository;
use Livewire\Component;

class ListOfWebhook extends Component
{
    /** Collection Property */
    public $listWebhook;

    /** Modal Property */
    public $modal;

    protected $listeners = [
        'notify', 'close'
    ];

    public function notify($message)
    {
        $this->dispatchBrowserEvent('notify', $message);
    }

    public function close()
    {
        $this->modal = null;
    }

    public function edit($id)
    {
        $this->modal = 'edit';

        $this->emit('data', $id);
    }

    public function changeStatus(WebhookRepository $webhookRepository, $value)
    {
        $result = $webhookRepository->updateStatus($value);

        $this->dispatchBrowserEvent('notify', $result); 
    }

    public function render()
    {
        $this->listWebhook = Webhook::get();

        return view('livewire.setting.webhook.list-of-webhook');
    }
}
