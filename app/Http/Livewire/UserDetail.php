<?php

namespace App\Http\Livewire;

use App\Services\UserService;
use Livewire\Component;

class UserDetail extends Component
{
    private $service;
    public $tab = 'curso';
    public $userId;

    public function __construct()
    {
        $this->service = new UserService;
    }

    public function mount()
    {
        $this->userId = request()->route('id');
    }

    public function getUserProperty()
    {
        return $this->service->find($this->userId);
    }

    public function render()
    {
        return view('livewire.user.detail');
    }

    public function getActivityProperty()
    {
        return $this->service->resumeActivity($this->userId);
    }
}
