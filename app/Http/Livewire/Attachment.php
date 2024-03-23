<?php

namespace App\Http\Livewire;

use App\Services\AttachmentService;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\WithFileUploads;

class Attachment extends Base
{
    use WithFileUploads;

    public string | null $attachmentId;
    public string | null $lessonId = null;
    public string | null $eventId = null;
    public string | null $userId = null;
    public $attachment;
    public $isOpenAttachment = false;

    protected $listeners = [
        'refreshAttachment' => '$refresh'
    ];

    public function mount(AttachmentService $service, $attachmentId = null, $lessonId = null, $userId = null, $eventId = null)
    {
        $this->lessonId = $lessonId;
        $this->eventId = $eventId;
        $this->userId = $userId;
        $this->attachmentId = $attachmentId;

        if ($attachmentId) {
            $data = $service->find($attachmentId);
            $this->form['name'] = $data->name;
            $this->form['after_class'] = $data->after_class;
        }
    }

    public function render()
    {
        return view('livewire.shared.attachment');
    }

    public function store(AttachmentService $service)
    {
        try {
            $this->form['lesson_id'] = $this->lessonId;
            $this->form['event_id'] = $this->eventId;
            $this->form['user_id'] = $this->userId;

            if (isset($this->attachmentId)) {
                $this->form['id'] = $this->attachmentId;
            }

            if ($this->attachment) {
                $attachment = $this->attachment->store('attachment', 'public');
                $this->form['type'] = $this->attachment->extension();
                $this->form['path'] = Storage::url($attachment);
            }

            $service->store($this->form);

            $this->emit('refreshAttachment');
            if ($this->lessonId) {
                $this->emit('refreshClassroom');
            }
            $this->emit('refreshManage');
            $this->isOpenAttachment = false;
        } catch (ValidationException $e) {
            $this->setErrorMessages($e->validator->errors());
        } catch (Exception $e) {
            dd('Exception', $e);
        }
    }

    public function dellAttachment(AttachmentService $service)
    {
        $service->delete($this->attachmentId);
        $this->emit('refreshClassroom');
    }

}
