<?php
namespace App\Services;

use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;

class QuestionService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new Question();
    }

    public function getAll(array $filter = []): Collection
    {
        return $this->repository->with('activity')->where($filter)->get();
    }

    public function find(string $id): Question
    {
        return $this->repository->with('activity')->find($id);
    }

    public function create(array $data): Question
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
