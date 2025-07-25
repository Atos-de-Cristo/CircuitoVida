<?php
namespace App\Services;

use App\Models\Frequency;
use Illuminate\Database\Eloquent\Collection;

class FrequencyService extends BaseService
{
    protected $repository;

    protected $rules = [
        'event_id' => 'required|numeric',
        'lesson_id' => 'required|numeric',
        'user_id' => 'required|numeric',
        'inscription_id' => 'required|numeric'
    ];

    public function __construct()
    {
        $this->repository = new Frequency();
    }

    public function getAll(array $filter = []): Collection
    {
        return $this->repository->with('event', 'lesson', 'user')->where($filter)->get();
    }

    public function find(string $id): Frequency
    {
        return $this->repository->with('event', 'lesson', 'user')->find($id);
    }

    public function create(array $data): Frequency
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): bool
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
