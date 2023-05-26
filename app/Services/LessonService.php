<?php
namespace App\Services;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Collection;

class LessonService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new Lesson();
    }

    public function getAll(array $filter = []): Collection
    {
        return $this->repository->with('event', 'module')->where($filter)->get();
    }

    public function find(string $id): Lesson
    {
        return $this->repository->with('event', 'module')->find($id);
    }

    public function create(array $data): Lesson
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
