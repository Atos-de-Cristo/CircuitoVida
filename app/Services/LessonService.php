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
        return $this->repository->with('event', 'module', 'activities', 'attachments')->where($filter)->get();
    }

    public function find(string $id): Lesson
    {
        return $this->repository->with('event', 'module', 'activities', 'attachments')->find($id);
    }

    public function store(array $data): Lesson | bool
    {
        if (isset($data['id']) && !empty($data['id'])) {
            return $this->update($data, $data['id']);
        }
        return $this->create($data);
    }

    private function create(array $data): Lesson
    {
        return $this->repository->create($data);
    }

    private function update(array $data, int $id): bool
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
