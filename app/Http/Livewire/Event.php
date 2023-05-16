<?php

namespace App\Http\Livewire;

use App\Enums\{EventStatus, EventType};
use App\Services\EventService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Event extends Component
{
    use WithFileUploads;

    public $_id, $type, $name, $image, $start_date, $end_date, $local, $description, $tickets_limit, $value, $status;
    public $isOpen = false;
    protected $service;

    public function render(EventService $service)
    {
        $dataAll = $service->getAll();
        $typesList = EventType::cases();
        $statusList = EventStatus::cases();
        return view('livewire.event.index', compact('dataAll', 'typesList', 'statusList'));
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
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $imgName = $this->image->store('files', 'public');

        $request = [
            'type' => $this->type,
            'name' => $this->name,
            'image' =>  Storage::url($imgName),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'local' => $this->local,
            'description' => $this->description,
            'tickets_limit' => $this->tickets_limit,
            'value' => $this->value,
            'status' => $this->status
        ];

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
}
