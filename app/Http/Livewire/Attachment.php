<?php

namespace App\Http\Livewire;

use App\Services\AttachmentService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Attachment extends Component
{
    use WithFileUploads;

    public string | null $attachmentId;
    private $service;
    public $attachment, $name, $lessonId;
    public bool $isOpenAttachment = false;

    protected $listeners = [
        'refreshAttachment' => '$refresh'
    ];

    public function __construct()
    {
        $this->service = new AttachmentService;
    }

    public function mount($lessonId, $attachmentId)
    {
        $this->lessonId = $lessonId;
        $this->attachmentId = $attachmentId;

        if ($attachmentId) {
            $data = $this->service->find($attachmentId);
            $this->name = $data->name;
        }
    }

    public function render()
    {
        return view('livewire.shared.attachment');
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
        ]);

        $request = [
            'name' => $this->name
        ];

        if ($this->lessonId) {
            $request['lesson_id'] = $this->lessonId;
        }

        if (isset($this->attachmentId)) {
            $request['id'] = $this->attachmentId;
        }

        if ($this->attachment) {
            $request['type'] = $this->attachment->extension();
            $attachment = $this->attachment->store('attachment', 'public');
            $request['path'] = Storage::url($attachment);
        }

        $this->service->store($request);

        $this->emit('refreshClassroom');
        $this->emit('refreshAttachment');
        $this->isOpenAttachment = false;
    }

    private function resetInput()
    {
        $this->attachment = '';
        $this->name = '';
    }

    public function dellAttachment()
    {
        $this->service->delete($this->attachmentId);
        $this->emit('refreshClassroom');
    }
}
