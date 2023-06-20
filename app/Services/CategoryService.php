<?php
namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new Category();
    }

    public function getAll(array $filter = []): Collection
    {
        return $this->repository->with('events')->where($filter)->get();
    }

    public function find(string $id): Category
    {
        return $this->repository->with('events')->find($id);
    }

    public function store(array $data): Category | bool
    {
        if (isset($data['id']) && !empty($data['id'])) {
            return $this->update($data, $data['id']);
        }
        return $this->create($data);
    }

    private function create(array $data): Category
    {
        return $this->repository->create($data);
    }

    private function update(array $data, int $id): bool
    {
        $repo = $this->find($id);
        return $repo->update($data);
    }

    public function delete(string $id): bool
    {
        $repo = $this->find($id);
        return $repo->delete();
    }
}
