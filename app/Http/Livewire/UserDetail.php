<?php

namespace App\Http\Livewire;

use App\Services\UserService;
use Livewire\Component;

class UserDetail extends Component
{
    public $tab = 'curso';
    public $userId;

    protected $listeners = ['refreshUserDetail' => '$refresh'];

    public function getUserServiceProperty()
    {
        return new UserService;
    }

    public function mount()
    {
        $this->userId = request()->route('id');
    }

    public function getUserProperty()
    {
        return $this->userService->find($this->userId);
    }

    public function render()
    {
        return view('livewire.user.detail');
    }

    public function getActivityProperty()
    {
        return $this->userService->resumeActivity($this->userId);
    }
}
