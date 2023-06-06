<?php

namespace App\Http\Livewire;

use App\Enums\InscriptionStatus;
use App\Services\{EventService, InscriptionService, LessonService, ModuleService};
use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;

class EventManager extends Component
{
    use WithFileUploads;

    protected $listeners = [
        'refreshManage' => '$refresh',
        'closeModalFrequency' => 'closeModalFrequency',
        'closeModalMonitors' => 'closeModalMonitors',
        'closeModalLesson' => 'closeModalLesson'
    ];

    public $eventId, $nameModule;
    public $user_id, $event_id, $module_id, $title, $description, $video, $date, $itemdelete;
    public $lessonId, $moduleSelected;
    public $showConfirmationPopup = false;
    public $isOpenModule = false;
    public $isOpenLesson = false;
    public $isOpenMonitors = false;

    public function boot(Request $request)
    {
        $this->eventId = $request->id;
    }

    public function render(EventService $eventService, ModuleService $moduleService)
    {
        $event = $eventService->find($this->eventId);
        $modules = $moduleService->getAll(['event_id' => $this->eventId]);
        return view('livewire.event.manager', compact('event', 'modules'));
    }

    public function approveInscription(string $id, InscriptionService $inscriptionService)
    {
        $inscriptionService->update([
            'status' => InscriptionStatus::G->name,
        ], $id);

        $this->emit('refreshManage');
    }

    public function disapproveInscription(string $id, InscriptionService $inscriptionService)
    {
        $inscriptionService->update([
            'status' => InscriptionStatus::C->name,
        ], $id);

        $this->emit('refreshManage');
    }

    public function createModule()
    {
        $this->resetInputModule();
        $this->openModalModule();
    }

    public function editModule(string $id, ModuleService $service)
    {
        $this->resetInputModule();

        $moduleData = $service->find($id);

        $this->moduleSelected = $id;
        $this->nameModule = $moduleData->name;

        $this->openModalModule();
    }

    public function deleteItem(string $id)
    {
        $this->showConfirmationPopup = true;
        $this->itemdelete = $id;
    }

    public function confirmDelete(ModuleService $service)
    {
        $service->delete($this->itemdelete);
        $this->showConfirmationPopup = false;
    }

    public function openModalModule()
    {
        $this->isOpenModule = true;
    }

    public function closeModalModule()
    {
        $this->isOpenModule = false;
    }

    private function resetInputModule()
    {
        $this->moduleSelected = null;
        $this->nameModule = '';
    }

    public function storeModule(ModuleService $service)
    {
        $this->validate([
            'nameModule' => 'required'
        ]);

        $request = [
            'name' => $this->nameModule,
            'event_id' => $this->eventId
        ];

        if ($this->moduleSelected) {
            $service->update($request, $this->moduleSelected);
        } else {
            $service->create($request);
        }

        session()->flash('message', 'Modulo cadastrado com sucesso.');

        $this->closeModalModule();
        $this->resetInputModule();
    }

    public function openModalLesson(string $idModule, string | null $lessonId)
    {
        $this->moduleSelected = $idModule;
        $this->lessonId = $lessonId;
        $this->isOpenLesson = true;
    }

    public function dellLesson($id, LessonService $service)
    {
        $service->delete($id);
        $this->emit('refreshManage');
    }

    public function closeModalLesson()
    {
        $this->isOpenLesson = false;
    }

    public function openModalMonitors()
    {
        $this->isOpenMonitors = true;
    }

    public function closeModalMonitors()
    {
        $this->isOpenMonitors = false;
    }
}
