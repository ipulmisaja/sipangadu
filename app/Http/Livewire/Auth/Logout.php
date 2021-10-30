<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Logout extends Component
{
    public function logout()
    {
        Auth::logout();

        return redirect()->intended(env('APP_URL'));
    }

    public function render()
    {
        return view('livewire.auth.logout');
    }
}
