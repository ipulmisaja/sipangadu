<?php

namespace App\Http\Livewire\Auth;

use App\Repositories\Setting\UserRepository;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GantiPassword extends Component
{
    /** Livewire Propertis */
    public $password;
    public $passwordKonfirmasi;

    protected $rules = [
        'password'           => 'required|string|min:6',
        'passwordKonfirmasi' => 'required|string|min:6|same:password'
    ];

    public function save(UserRepository $userRepository)
    {
        $this->validate($this->rules);

        $result = $userRepository->gantiPassword(Auth::user(), $this);

        $this->emit('notify', $result);

        $this->emit('close');
    }

    public function render()
    {
        return view('livewire.auth.ganti-password');
    }
}
