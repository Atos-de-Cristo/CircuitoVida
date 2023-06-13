<?php

namespace App\Http\Livewire;

use App\Services\UserService;
use Illuminate\Http\Request;
use Livewire\Component;

class UserDetail extends Component
{
    private $service, $userId;

    public function __construct()
    {
        $this->service = new UserService;
    }

    public function mount(Request $request)
    {
        $this->userId = $request->id;
    }

    public function render()
    {
        dump($this->userId);
        return view('livewire.user.detail');
    }
}
