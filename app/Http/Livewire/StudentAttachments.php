<?php

namespace App\Http\Livewire;

use App\Services\AttachmentService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StudentAttachments extends Component
{
    public function getAttachmentServiceProperty()
    {
        return new AttachmentService;
    }

    public function getListProperty()
    {
        return $this->attachmentService->getAll(['user_id' => Auth::user()->id]);
    }

    public function getListLessonProperty()
    {
        return $this->attachmentService->getAllCourseActive(Auth::user()->id);
    }

    public function render()
    {
        $this->listLesson;
        return view('livewire.student.attachments');
    }
}
