<?php

namespace App\Http\Livewire;

use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StudentActivities extends Component
{
    public $user;

    public function getUserServiceProperty()
    {
        return new UserService;
    }

    public function mount()
    {
        $this->user = $this->userService->find(Auth::user()->id);
    }

    public function render()
    {
        return view('livewire.student.activities');
    }
}
