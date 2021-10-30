<?php

namespace App\Http\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserUnit extends Component
{
    public function render()
    {
        return view('livewire.profile.user-unit', [
            'unit' => null
        ]);
    }
}
