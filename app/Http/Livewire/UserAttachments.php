<?php

namespace App\Http\Livewire;

use App\Services\AttachmentService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserAttachments extends Component
{
    use WithFileUploads;

    public $name, $attachment, $userId;

    public function mount($user=null)
    {
        $this->userId = $user;
    }

    public function getAttachmentServiceProperty()
    {
        return new AttachmentService;
    }

    public function getListProperty()
    {
        return $this->attachmentService->getAll(['user_id' => $this->userId]);
    }

    public function render()
    {
        return view('livewire.user.attachments');
    }

    private function resetInput()
    {
        $this->name = '';
        $this->attachment = null;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'attachment'=> 'required',
        ]);

        $request = [
            'name' => $this->name,
            'user_id' => $this->userId
        ];

        $request['type'] = $this->attachment->extension();
        $attachment = $this->attachment->store('attachment', 'public');
        $request['path'] = Storage::url($attachment);

        $this->attachmentService->store($request);

        $this->resetInput();
    }
}
