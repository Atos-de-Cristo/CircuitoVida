<?php
namespace App\Services;

use App\Models\Module;
use Illuminate\Database\Eloquent\Collection;

class ModuleService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new Module();
    }

    public function getAll(array $filter = []): Collection
    {
        return $this->repository->with('event')->with('lessons')->where($filter)->get();
    }

    public function find(string $id): Module
    {
        return $this->repository->with('event')->find($id);
    }

    public function create(array $data): Module
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
