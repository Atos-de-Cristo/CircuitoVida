<?php

namespace App\Http\Livewire;

use App\Services\AttachmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Attachment extends Component
{
    use WithFileUploads;

    public $attachment, $name, $lessonId;

    public function boot(Request $request)
    {
        $this->lessonId = $request->id;
    }

    public function render()
    {
        return view('livewire.shared.attachment');
    }

    public function closeModal()
    {
        $this->emit('closeModalAttachment');
    }

    public function store()
    {
        if ($this->attachment) {
            if ($this->lessonId) {
                $this->saveAttachmentLesson();
            }
        }
    }

    public function saveAttachmentLesson()
    {
        $service = new AttachmentService;
        $this->validate([
            'name' => 'required',
        ]);

        $request = [
            'lesson_id' => $this->lessonId,
            'type' => $this->attachment->extension(),
            'name' => $this->name
        ];

        $attachment = $this->attachment->store('attachment', 'public');
        $request['path'] = Storage::url($attachment);

        $service->create($request);

        $this->emit('refreshClassroom');
        $this->closeModal();
    }
}
