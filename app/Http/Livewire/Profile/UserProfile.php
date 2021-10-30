<?php

namespace App\Http\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserProfile extends Component
{
    public function render()
    {
        return view('livewire.profile.user-profile', [
            'nama' => Auth::user()->nama,
            'foto' => Auth::user()->foto
        ]);
    }
}
