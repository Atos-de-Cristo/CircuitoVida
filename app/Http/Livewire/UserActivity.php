<?php

namespace App\Http\Livewire;

use App\Services\UserService;
use Livewire\Component;

class UserActivity extends Component
{
    public $user;

    public function getUserServiceProperty()
    {
        return new UserService;
    }

    public function mount($user=null)
    {
        $this->user = $this->userService->find($user);
    }

    public function render()
    {
        return view('livewire.user.activity');
    }
}
