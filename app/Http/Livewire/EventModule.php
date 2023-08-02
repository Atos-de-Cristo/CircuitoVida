<?php

namespace App\Http\Livewire;

use App\Services\ModuleService;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class EventModule extends Component
{
    public $eventId, $nameModule, $moduleId;
    public $isOpenModule = false;

    public function getModuleServiceProperty()
    {
        return new ModuleService;
    }

    public function mount(string $eventId, string $moduleId = null)
    {
        $this->eventId = $eventId;
        $this->moduleId = $moduleId;
    }

    public function render()
    {
        return view('livewire.event.module.add');
    }

    public function openModalModule()
    {
        $this->isOpenModule = true;
    }

    public function closeModalModule()
    {
        $this->nameModule = '';
        $this->isOpenModule = false;
    }

    public function editModule(){
        $moduleData = $this->moduleService->find($this->moduleId);
        $this->nameModule = $moduleData->name;
        $this->openModalModule();
    }

    public function storeModule()
    {
        try {
            $request = [
                'id' => $this->moduleId ?? null,
                'name' => $this->nameModule,
                'event_id' => $this->eventId
            ];

            $this->moduleService->store($request);

            $this->closeModalModule();
            $this->emit('refreshManage');
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();

            $this->resetErrorBag();

            foreach ($errors->messages() as $field => $fieldErrors) {
                foreach ($fieldErrors as $error) {
                    $this->addError($field, $error);
                }
            }
        }
    }

    public function deleModule()
    {
        $this->moduleService->delete($this->moduleId);
        $this->emit('refreshManage');
    }
}
