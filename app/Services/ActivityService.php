<?php
namespace App\Services;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Collection;

class ActivityService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new Activity();
    }

    public function getAll(array $filter = []): Collection
    {
        return $this->repository->with('event', 'lesson')->where($filter)->get();
    }

    public function find(string $id): Activity
    {
        return $this->repository->with('event', 'lesson')->find($id);
    }

    public function store(array $data): Activity | bool
    {
        if (isset($data['id'])) {
            return $this->update($data, $data['id']);
        }
        return $this->create($data);
    }

    private function create(array $data): Activity
    {
        return $this->repository->create($data);
    }

    private function update(array $data, int $id): bool
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
