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

    public function getAll(string $activityId): Collection
    {
        return $this->repository->with('activity')->where('activity_id', $activityId)->get();
    }

    public function find(string $id): Question
    {
        return $this->repository->with('activity')->find($id);
    }

    public function store(array $data): Question | bool
    {
        if (isset($data['id'])) {
            return $this->update($data, $data['id']);
        }
        return $this->create($data);
    }

    private function create(array $data): Question
    {
        $processedOptions = collect($data['options'])->map(function ($option) {
            return [
                'text' => $option['text'],
                'correct' => $option['correct'],
            ];
        });
        $data['options'] = $processedOptions->toJson();
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
