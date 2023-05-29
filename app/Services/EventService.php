<?php
namespace App\Services;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
class EventService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new Event();
    }

    public function getAll(array $filter = []): Collection
    {
        return $this->repository->with('inscriptions')->where($filter)->get();
    }
    public function paginate($search, $sortBy, $sortDirection): LengthAwarePaginator
    {
        return $this->repository
            ->where('name', 'LIKE', '%' . $search . '%')
            ->orderBy($sortBy, $sortDirection)
            ->paginate(12);
    }

    public function find(string $id): Event
    {
        return $this->repository->with('inscriptions')->find($id);
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
