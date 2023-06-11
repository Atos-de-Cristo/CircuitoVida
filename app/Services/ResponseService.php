<?php
namespace App\Services;

use App\Models\Response;
use Illuminate\Database\Eloquent\Collection;

class ResponseService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new Response();
    }

    public function getAll(string $questionId): Collection
    {
        return $this->repository
            ->with('user', 'question')
            ->whereRelation('question', 'id', $questionId)
            ->get();
    }

    public function find(string $id): Response
    {
        return $this->repository->with('user', 'question')->find($id);
    }

    public function create(array $data): Response
    {
        return $this->repository->create($data);
    }

    public function update(array $data, int $id): bool
    {
        $repo = $this->find($id);
        return $repo->update($data);
    }
}
