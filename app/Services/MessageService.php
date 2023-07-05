<?php
namespace App\Services;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new Message();
    }

    public function find(int $id): Message
    {
        return $this->repository->find($id);
    }

    public function listMessageUser(): Message
    {
        return $this->repository->where('user_for', Auth::user()->id)->get();
    }

    public function send(array $data): Message
    {
        $data['user_send'] = Auth::user()->id;
        $data['data_send'] = date('Y-m-d H:i:s');
        return $this->repository->create($data);
    }

    public function read(int $id): bool
    {
        $repo = $this->find($id);
        return $repo->update([
            'read' => true,
            'date_read' => date('Y-m-d H:i:s')
        ]);
    }
}
