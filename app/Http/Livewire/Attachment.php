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
    public $attachment, $lessonId;
    public $isOpenAttachment = false;

    protected $listeners = [
        'refreshAttachment' => '$refresh'
    ];

    public function mount($lessonId, $attachmentId, AttachmentService $service)
    {
        $this->lessonId = $lessonId;
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
            if ($this->lessonId) {
                $this->form['lesson_id'] = $this->lessonId;
            }

            if (isset($this->attachmentId)) {
                $this->form['id'] = $this->attachmentId;
            }

            if ($this->attachment) {
                $attachment = $this->attachment->store('attachment', 'public');
                $this->form['type'] = $this->attachment->extension();
                $this->form['path'] = Storage::url($attachment);
            }

            $service->store($this->form);

            $this->emit('refreshClassroom');
            $this->emit('refreshAttachment');
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
