<?php
namespace App\Services;

use App\Models\Inscription;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class InscriptionService
{
    protected $repository;

    public function __construct(Inscription $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): Collection
    {
        return $this->repository->where('user_id', Auth::user()->id)->with('event', 'user')->get();
    }

    public function find(string $id): Inscription
    {
        return $this->repository->find($id);
    }

    public function create(array $data): Inscription
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
