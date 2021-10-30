<?php

namespace App\Http\Livewire\Setting\Role;

use App\Repositories\Setting\RoleRepository;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class CreateEditRole extends Component
{
    /** @var string */
    public $stage;

    /** @var Role */
    public $role;

    /** @var string */
    public $name;

    /** @var string */
    public $description;

    protected $listeners = ['data'];

    public function mount($stage)
    {
        $this->stage = $stage;
    }

    public function data($id)
    {
        $this->role        = Role::findOrFail($id);
        $this->name        = $this->role->name;
        $this->description = $this->role->description;
    }

    public function save(RoleRepository $roleRepository)
    {
        // $this->validate();

        $result = $roleRepository->store($this);

        $this->emit('notify', $result);

        $this->emit('close');
    }

    public function update(RoleRepository $roleRepository)
    {
        // $this->validate();

        $result = $roleRepository->update($this);

        $this->emit('notify', $result);

        $this->emit('close');
    }

    public function render()
    {
        return view('livewire.setting.role.create-edit-role');
    }
}
