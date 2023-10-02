<?php
namespace App\Services;

use App\Models\Lesson;
use Error;
use Illuminate\Database\Eloquent\Collection;

class LessonService extends BaseService
{
    protected $repository;

    protected $rules = [
        'event_id' => 'required|numeric',
        'module_id' => 'required|numeric',
        'title' => 'required|max:191',
        'description' => 'min:3',
        'video' => 'max:191',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
    ];

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
        $id = $data['id'] ?? null;

        if (isset($id) && !empty($id)) {
            return $this->update($data, $id);
        }

        $dataValidate = $this->validateForm($data);
        return $this->create($dataValidate);
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
        //TODO: travando delete até confirmacao de acao
        throw new Error('Serviço indisponível!');
        $repo = $this->find($id);
        $repo->delete();
    }
}
