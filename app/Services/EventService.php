<?php
namespace App\Services;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;

class EventService
{
    protected $repository;

    public function __construct(Event $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): Collection
    {
        return $this->repository->all();
    }

    public function find(string $id): Event
    {
        return $this->repository->find($id);
    }

    public function create(array $data): Event
    {
        return $this->repository->create($data);
    }

    public function update(array $data, int $id): bool
    {
        $repo = $this->find($id);
        return $repo->update($data);
    }

    public function delete(string $id): void
    {
        $repo = $this->find($id);
        $repo->delete();
    }
}
