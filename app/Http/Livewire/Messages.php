<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;



class Messages extends Component
{
    public function render()
    {
        $users = User::all();
        return view('livewire.messages', compact('users'));
    }

    public function getUser($user)
    {
        //
        dd($user);
    }
}
