<?php

namespace App\Http\Livewire;

use App\Models\Receipt;
use App\Models\Ticket;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class User extends Component
{
    public $user;

    public $tickets;

    public function mount()
    {
        $id = explode('/', URL::full());
        $this->user = \App\Models\User::find(end($id));
        $this->tickets = Ticket::where('user_id', end($id))->get();
    }

    public function render()
    {
        return view('livewire.user');
    }
}
