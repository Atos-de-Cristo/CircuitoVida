<?php
namespace App\Services;

use App\Models\Module;
use Illuminate\Database\Eloquent\Collection;

class ModuleService extends BaseService
{
    protected $repository;

    protected $rules = [
        'name' => 'required|max:191|min:3',
        'event_id' => 'required|numeric'
    ];

    public function __construct()
    {
        $this->repository = new Module();
    }

    public function getAll(array $filter = []): Collection
    {
        return $this->repository->with('event')->with('lessons')->where($filter)->get();
    }

    public function find(string $id): Module
    {
        return $this->repository->with('event')->find($id);
    }

    public function store(array $data): Module | bool
    {
        if (isset($data['id']) && !empty($data['id'])) {
            return $this->update($data, $data['id']);
        }

        $dataValid = $this->validateForm($data);
        return $this->create($dataValid);
    }

    private function create(array $data): Module
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
