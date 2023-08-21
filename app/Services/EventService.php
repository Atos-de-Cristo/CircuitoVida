<?php
namespace App\Services;

use App\Enums\EventStatus;
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

    public function getLessonsWithCounts(array $filter = []): Collection
    {
        return $this->repository
            ->withCount(['inscriptions', 'lessons'])
            ->where($filter)
            ->get();
    }

    public function listActive(): Collection
    {
        return $this->repository
            ->with('inscriptions')
            ->where('status', '!=', EventStatus::P->name)
            ->where('status', '!=', EventStatus::F->name)
            ->get();
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
        return $this->repository->with('inscriptions')->with('modules')->with('lessons')->find($id);
    }

    public function store(array $data): Event | bool
    {
        if (isset($data['id']) && !empty($data['id'])) {
            return $this->update($data, $data['id']);
        }
        return $this->create($data);
    }

    private function create(array $data): Event
    {
        $create = $this->repository->updateOrCreate($data);
        if (isset($data['monitors'])) {
            $create->users()->sync($data['monitors']);
        }
        return $create;
    }

    private function update(array $data, int $id): bool
    {
        $repo = $this->find($id);
        if (isset($data['monitors'])) {
            if (empty($data['monitors'])) {
                $repo->monitors()->detach();
            } else {
                $repo->monitors()->sync($data['monitors']);
            }
        }
        return $repo->update($data);
    }

    public function delete(string $id): void
    {
        $repo = $this->find($id);
        $repo->delete();
    }
}
