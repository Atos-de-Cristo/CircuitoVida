<?php
namespace App\Services;

use App\Models\Activity;
use Error;
use Illuminate\Database\Eloquent\Collection;

class ActivityService
{
    protected $repository;
    protected $messageService;

    public function __construct()
    {
        $this->repository = new Activity();
        $this->messageService = new MessageService();
    }

    public function getAll(array $filter = []): Collection
    {
        return $this->repository->with('lesson')->where($filter)->get();
    }

    public function find(string $id): Activity
    {
        return $this->repository->with('lesson', 'users')->find($id);
    }

    public function listStudents(string $id): Activity
    {
        return $this->repository->with('lesson.event.inscriptions.user')->find($id);
    }

    public function store(array $data): Activity | bool
    {
        if (isset($data['id']) && !empty($data['id'])) {
            return $this->update($data, $data['id']);
        }
        return $this->create($data);
    }

    private function create(array $data): Activity
    {
        $activity = $this->repository->create($data);
        if ($data['type'] === 'E') {
            $activity->users()->sync($data['userListActivity']);
            foreach ($data['userListActivity'] as $userId) {
                $this->messageService->send([
                    'message' => 'Nova atividade adicionada ao seu perfil.',
                    'user_for' => $userId
                ]);
            }
        }
        return $activity;
    }

    private function update(array $data, int $id): bool
    {
        $repo = $this->find($id);
        $repo->update($data);
        if ($data['type'] === 'E') {
            $repo->users()->sync($data['userListActivity']);
            foreach ($data['userListActivity'] as $userId) {
                $this->messageService->send([
                    'message' => 'Atividade editada no seu perfil.',
                    'user_for' => $userId
                ]);
            }
        }
        return true;
    }

    public function delete(string $id): void
    {
        //TODO: travando delete até confirmacao de acao
        throw new Error('Serviço indisponível!');
        $repo = $this->find($id);
        $repo->delete();
    }
}
