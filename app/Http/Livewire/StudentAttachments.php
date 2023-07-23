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

    public function render()
    {
        return view('livewire.student.attachments');
    }
}
