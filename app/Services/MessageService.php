<?php
namespace App\Services;

use App\Models\Message;
use Illuminate\Pagination\LengthAwarePaginator;
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

    public function listMessageUser(?int $id = null, ?string $search = null): LengthAwarePaginator
    {
        $query = $this->repository
            ->with('userSend', 'userFor')
            ->orderBy('date_send', 'desc');

        $query->where('user_for', $id ?? Auth::user()->id);

        if ($search) {
            $query->whereHas('userSend', function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%');
            });
        }

        return $query->paginate(10);
    }

    public function listMessageUnread(): Collection
    {
        return $this->repository
            ->with('userSend', 'userFor')
            ->where('user_for', Auth::user()->id)
            ->where('read', false)
            ->orderBy('date_send', 'desc')
            ->get();
    }

    public function send(array $data)
    {
        $data['user_send'] = Auth::user()->id;
        $data['date_send'] = date('Y-m-d H:i:s');
        $data['read'] = false;
        return $this->repository->create($data);
    }

    public function sendGroup(array $data): void
    {
        foreach ($data['list_for'] as $forId) {
            $this->send([
                'message' => $data['message'],
                'user_for' => $forId
            ]);
        }
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
