<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

class UserService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new User;
    }

    public function getAll(): Collection
    {
        return $this->repository->all();
    }

    public function getMonitors(): Collection
    {
        return $this->repository->whereHas('permissions', function (Builder $query) {
            $query->where('permission', 'monitor');
        })->get();
    }

    public function paginate($search, $sortBy, $sortDirection): LengthAwarePaginator
    {
        return $this->repository
            ->where('name', 'LIKE', '%' . $search . '%')
            ->orderBy($sortBy, $sortDirection)
            ->paginate(12);
    }

    public function find(string $id): User
    {
        return $this->repository->find($id);
    }

    public function create(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->repository->create($data);
        $user->permissions()->sync($data['permissions']);
        return $user;
    }

    public function update(array $data, int $id): void
    {
        $data['password'] = Hash::make($data['password']);
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
