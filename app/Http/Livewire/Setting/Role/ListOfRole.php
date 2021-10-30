<?php

namespace App\Http\Livewire\Setting\Role;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class ListOfRole extends Component
{
    /** @var string */
    public $modal;

    /** @var collection */
    public $list_role;

    protected $listeners = ['close', 'notify'];

    public function mount()
    {
        $this->list_role = Role::get();
    }

    public function hydrate()
    {
        $this->list_role = Role::get();
    }

    public function edit($id)
    {
        $this->modal = 'edit';

        $this->emit('data', $id);
    }

    public function notify($message)
    {
        $this->dispatchBrowserEvent('notify', $message);
    }

    public function close()
    {
        $this->modal = null;
    }



    public function render()
    {
        return view('livewire.setting.role.list-of-role');
    }
}
