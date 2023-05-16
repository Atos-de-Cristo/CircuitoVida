<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    protected $repository;

    public function __construct(User $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): Collection
    {
        return $this->repository->all();
    }

    public function find(string $id): User
    {
        return $this->repository->find($id);
    }

    public function create(array $data): User
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
