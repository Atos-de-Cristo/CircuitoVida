<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function paginate($search, $sortBy, $sortDirection): LengthAwarePaginator
    {
        return $this->repository
            ->where('name', 'LIKE', '%' . $search . '%')
            ->orderBy($sortBy, $sortDirection)
            ->paginate(10);
    }

    public function find(string $id): User
    {
        return $this->repository->find($id);
    }

    public function create(array $data): User
    {
        $user = $this->repository->create($data);
        $user->permissions()->sync($data['permissions']);
        return $user;
    }

    public function update(array $data, int $id): void
    {
        $repo = $this->find($id);
        $repo->update($data);
        $repo->permissions()->sync($data['permissions']);
    }

    public function delete(string $id): void
    {
        $repo = $this->find($id);
        $repo->delete();
    }
}
