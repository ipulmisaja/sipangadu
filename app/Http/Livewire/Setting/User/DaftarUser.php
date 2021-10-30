<?php

namespace App\Http\Livewire\Setting\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarUser extends Component
{
    use WithPagination;

    public $modal;

    protected $listeners = ['close', 'notify'];

    public function notify($message)
    {
        $this->dispatchBrowserEvent('notify', $message);
    }

    public function close()
    {
        $this->modal = null;
    }

    public function edit(String $slug)
    {
        $this->modal = 'edit';

        $this->emit('data', $slug);
    }

    public function render()
    {
        return view('livewire.setting.user.daftar-user', [
            'daftarUser' => User::with(['unitRelationship', 'pangkatGolonganRelationship'])
                                -> orderBy('id')
                                -> get()
        ]);
    }
}
