<?php

namespace App\Http\Livewire;

use App\Enums\{EventStatus, EventType};
use App\Services\EventService;
use Livewire\Component;

class Event extends Component
{
    public $type, $name, $image, $start_date, $end_date, $local, $description, $tickets_limit, $value, $status;
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

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        // Post::updateOrCreate(['id' => $this->post_id], [
        //     'title' => $this->title,
        //     'body' => $this->body
        // ]);

        session()->flash('message',
            $this->post_id ? 'Post Updated Successfully.' : 'Post Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $event = $this->service->find($id);
        $this->name = $event->name;
        $this->description = $event->description;

        $this->openModal();
    }

    public function delete($id)
    {
        // Post::find($id)->delete();
        session()->flash('message', 'Post Deleted Successfully.');
    }
}
