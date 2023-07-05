<?php
namespace App\Services;

use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;
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

    public function listMessageUser(int | null $id = null): Collection
    {
        return $this->repository
            ->with('userSend', 'userFor')
            ->where('user_for', ($id) ? $id : Auth::user()->id)
            ->orderBy('date_send', 'asc')
            ->get();
    }

    public function send(array $data): Message
    {
        $data['user_send'] = Auth::user()->id;
        $data['date_send'] = date('Y-m-d H:i:s');
        $data['read'] = false;
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
