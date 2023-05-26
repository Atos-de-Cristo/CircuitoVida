<?php

namespace App\Http\Livewire;

use App\Enums\{EventStatus, EventType};
use App\Services\EventService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
class Event extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $_id, $type, $name, $image, $start_date, $end_date, $local, $description, $tickets_limit, $value, $status, $newImage;
    public $isOpen = false;
    protected $service;

    public $search = '';
    public $sortBy = 'id';
    public $sortDirection = 'desc';

    public function render(EventService $service)
    {
        $dataAll = $service->paginate($this->search,$this->sortBy, $this->sortDirection);
        $typesList = EventType::cases();
        $statusList = EventStatus::cases();
        return view('livewire.event.list', compact('dataAll', 'typesList', 'statusList'));
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields(){
        $this->_id = '';
        $this->type = EventType::P;
        $this->name = '';
        $this->image = '';
        $this->newImage = '';
        $this->start_date = '';
        $this->end_date = '';
        $this->local = '';
        $this->description = '';
        $this->tickets_limit = '';
        $this->value = '';
        $this->status = EventStatus::P;
    }

    public function store(EventService $service)
    {
        $this->validate([
            'name' => 'required',
            'local' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $request = [
            'type' => $this->type,
            'name' => $this->name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'local' => $this->local,
            'description' => $this->description,
            'tickets_limit' => $this->tickets_limit,
            'value' => $this->value,
            'status' => $this->status
        ];

        if ($this->newImage) {
            $imgName = $this->newImage->store('files', 'public');
            $request['image'] = Storage::url($imgName);
        }

        if ($this->_id) {
            $service->update($request, $this->_id);
        }else{
            $service->create($request);
        }

        session()->flash('message',
            $this->_id ? 'Evento editado com sucesso.' : 'Evento cadastrado com sucesso.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id, EventService $service)
    {
        $event = $service->find($id);
        $this->_id = $event->id;
        $this->name = $event->name;
        $this->image = $event->image;
        $this->newImage = null;
        $this->description = $event->description;
        $this->type = $event->type;
        $this->start_date = $event->start_date;
        $this->end_date = $event->end_date;
        $this->local = $event->local;
        $this->tickets_limit = $event->tickets_limit;
        $this->value = $event->value;
        $this->status = $event->status;

        $this->openModal();
    }

    public function delete($id, EventService $service)
    {
        $service->delete($id);
        session()->flash('message', 'Evento deletado com sucesso.');
    }

    public function manager($id){
        redirect(route('eventManager', ['id' => $id]));
    }
}
