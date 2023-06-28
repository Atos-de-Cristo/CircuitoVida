<?php

namespace App\Http\Livewire;

use App\Services\InscriptionService;
use Livewire\Component;

class ListLesson extends Component
{
    public function getInscriptionServiceProperty()
    {
        return new InscriptionService;
    }

    public function getInscriptionsProperty()
    {
        return $this->inscriptionService->getInscriptionActive();
    }

    public function render()
    {
        return view('livewire.dashboard.list-lesson');
    }
}
