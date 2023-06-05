<?php

namespace App\Http\Livewire;

use App\Enums\InscriptionStatus;
use App\Services\{EventService, InscriptionService, LessonService, ModuleService};
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class EventManager extends Component
{
    use WithFileUploads;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'closeModalActivity' => 'closeModalActivity',
        'closeModalFrequency' => 'closeModalFrequency',
        'closeModalMonitors' => 'closeModalMonitors'
    ];

    public $eventId, $nameModule;
    public $user_id, $event_id, $module_id, $title, $description, $video, $slide, $date;
    public $lessonId, $moduleSelected;

    public $isOpenModule = false;
    public $isOpenLesson = false;
    public $isOpenActivity = false;
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

        $this->emit('refreshComponent');
    }

    public function disapproveInscription(string $id, InscriptionService $inscriptionService)
    {
        $inscriptionService->update([
            'status' => InscriptionStatus::C->name,
        ], $id);

        $this->emit('refreshComponent');
    }

    public function createModule()
    {
        $this->resetInputModule();
        $this->openModalModule();
    }

    public function editModule($id, ModuleService $service)
    {
        $this->resetInputModule();

        $moduleData = $service->find($id);

        $this->moduleSelected = $id;
        $this->nameModule = $moduleData->name;

        $this->openModalModule();
    }

    public function dellModule($id, ModuleService $service)
    {
        $service->delete($id);
        $this->emit('refreshComponent');
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
        }else{
            $service->create($request);
        }

        session()->flash('message', 'Modulo cadastrado com sucesso.');

        $this->closeModalModule();
        $this->resetInputModule();
    }

    public function createLesson()
    {
        $this->resetInputLesson();
        $this->openModalLesson();
    }

    public function editLesson($id, LessonService $service)
    {
        $this->resetInputLesson();

        $lessonData = $service->find($id);
        $this->module_id = $lessonData->module->id;
        $this->lessonId = $id;
        $this->title = $lessonData->title;
        $this->description = $lessonData->description;
        $this->video = $lessonData->video;
        $this->slide = $lessonData->slide;
        $this->date = $lessonData->date;

        $this->openModalLesson();
    }

    public function dellLesson($id, LessonService $service)
    {
        $service->delete($id);
        $this->emit('refreshComponent');
    }

    public function openModalLesson()
    {
        $this->isOpenLesson = true;
    }

    public function closeModalLesson()
    {
        $this->isOpenLesson = false;
    }

    private function resetInputLesson()
    {
        $this->user_id = '';
        $this->event_id = '';
        $this->title = '';
        $this->description = '';
        $this->video = '';
        $this->slide = '';
        $this->date = '';
    }

    public function storeLesson(LessonService $service)
    {
        $this->validate([
            'title' => 'required',
            'module_id' => 'required',
            'date' => 'required',
            'slide' => 'mimes:pdf|max:5120'
        ]);

        $request = [
            'event_id' => $this->eventId,
            'module_id' => $this->module_id,
            'title' => $this->title,
            'description' => $this->description,
            'video' => $this->video,
            'date' => $this->date,
        ];

        if ($this->slide) {
            $imgName = $this->slide->store('files/slide', 'public');
            $request['slide'] = Storage::url($imgName);
        }

        if ($this->lessonId) {
            $service->update($request, $this->lessonId);
        }else{
            $service->create($request);
        }

        session()->flash('message', 'Aula cadastrado com sucesso.');

        $this->closeModalLesson();
        $this->resetInputLesson();
    }

    public function openModalActivity(string $lessonId)
    {
        $this->lessonId = $lessonId;
        $this->isOpenActivity = true;
    }

    public function closeModalActivity()
    {
        $this->isOpenActivity = false;
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
