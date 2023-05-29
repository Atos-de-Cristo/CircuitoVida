<?php
namespace App\Services;

use App\Models\Frequency;
use Illuminate\Database\Eloquent\Collection;

class FrequencyService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new Frequency();
    }

    public function getAll(array $filter = []): Collection
    {
        return $this->repository->with('event', 'lesson', 'user')->where($filter)->get();
    }

    public function find(string $id): Frequency
    {
        return $this->repository->with('event', 'lesson', 'user')->find($id);
    }

    public function create(array $data): bool
    {
        return $this->repository->insert($data);
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
