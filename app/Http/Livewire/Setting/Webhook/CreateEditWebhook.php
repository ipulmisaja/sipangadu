<?php

namespace App\Http\Livewire\Setting\Webhook;

use App\Models\Webhook;
use App\Repositories\Setting\WebhookRepository;
use Livewire\Component;

class CreateEditWebhook extends Component
{
    /** Model Properties */
    public $application;
    public $url;
    public $webhook;

    /** Modal Stage */
    public $stage;

    protected $listeners = ['data'];

    protected $rules = [
        'application' => 'required|string|min:3',
        'url'         => 'required|string|min:5'
    ];

    public function mount($stage)
    {
        $this->stage = $stage;
    }

    public function data($id)
    {
        $this->webhook = Webhook::findOrfail($id);

        $this->application = $this->webhook->application;
        $this->url         = $this->webhook->url;
    }

    public function create(WebhookRepository $webhookRepository)
    {
        $this->validate($this->rules);

        $result = $webhookRepository->store($this);

        $this->emit('notify', $result);

        $this->emit('close');
    }

    public function edit(WebhookRepository $webhookRepository)
    {
        $this->validate($this->rules);

        $result = $webhookRepository->update($this);

        $this->emit('notify', $result);

        $this->emit('close');
    }

    public function render()
    {
        return view('livewire.setting.webhook.create-edit-webhook');
    }
}
