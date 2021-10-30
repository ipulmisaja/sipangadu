<?php

namespace App\Http\Livewire\Setting\User;

use App\Models\PangkatGolongan;
use App\Models\Unit;
use App\Models\User;
use App\Repositories\Setting\UserRepository;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class CreateEditUser extends Component
{
    /** @var string */
    public $stage;

    /** @var collection */
    public $list_roles;
    public $list_unit;
    public $list_rank_group;

    /** Model Properties */
    public $name;
    public $bpsId;
    public $staffId;
    public $email;
    public $password;
    public $unit;
    public $rank_group;
    public $role;
    public $roleArray = [];

    /** @var User */
    public $user;

    /** @var string */
    public $selectedUnit;
    public $selectedRankGroup;

    protected $listeners = ['data'];

    public function mount($stage)
    {
        $this->stage = $stage;

        $this->list_roles = Role::get();

        $this->list_unit  = Unit::get();

        $this->list_rank_group = PangkatGolongan::get();
    }

    public function updatedRole($value)
    {
        array_push($this->roleArray, $value);
    }

    public function data($slug)
    {
        $this->user              = User::where('slug', $slug)->first();
        $this->name              = $this->user->nama;
        $this->bpsId             = $this->user->bps_id;
        $this->staffId           = $this->user->nip_id;
        $this->email             = $this->user->email;
        $this->selectedUnit      = $this->user->unitRelationship->nama ?? '-';
        $this->selectedRankGroup = $this->user->pangkatGolonganRelation->nama ?? '-';

        foreach ($this->user->roles as $role) {
            array_push($this->roleArray, $role->name);
        }
    }

    public function deleteRole($value)
    {
        if (($key = array_search($value, $this->roleArray)) !== false) {
            unset($this->roleArray[$key]);
        }
    }

    public function save(UserRepository $userRepository)
    {
        // $this->validate();

        $result = $userRepository->store($this);

        $this->emit('notify', $result);

        $this->emit('close');
    }

    public function update(UserRepository $userRepository)
    {
        // $this->validate();

        $result = $userRepository->update($this);

        $this->emit('notify', $result);

        $this->emit('close');
    }

    public function render()
    {
        return view('livewire.setting.user.create-edit-user');
    }
}
