<?php

namespace App\Http\Livewire;
use App\Services\{CategoryService, EventService, UserService};
use Livewire\Component;

class DeleteConfirmation extends Component
{
    public $itemId, $service;

    public $isOpenDelete = false;
    public function getServiceProperty()
    {
        return app('App\Services\\' . $this->service);
    }
    public function openModal()
    {
        $this->isOpenDelete = true;
    }

    public function closeModal()
    {
        $this->isOpenDelete = false;
    }

   
    public function delete()
    {
    
     $this->Service->delete($this->itemId);
     $this->isOpenDelete = false;
     $this->emit('eventoExclusaoRealizada');
    }
    public function render()
    {
        return view('livewire.shared.delete-confirmation');
    }
}
