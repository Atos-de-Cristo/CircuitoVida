<?php
namespace App\Services;

use App\Models\Attachment;
use Illuminate\Database\Eloquent\Collection;

class AttachmentService
{
    protected $repository;
    protected $messageService;

    public function __construct()
    {
        $this->repository = new Attachment();
        $this->messageService = new MessageService();
    }

    public function getAll(array $filter = []): Collection
    {
        return $this->repository->with('lesson')->where($filter)->get();
    }

    public function find(string $id): Attachment
    {
        return $this->repository->with('lesson')->find($id);
    }

    public function store(array $data): Attachment | bool
    {
        if (isset($data['id']) && !empty($data['id'])) {
            return $this->update($data, $data['id']);
        }
        return $this->create($data);
    }

    private function create(array $data): Attachment
    {
        $data = $this->repository->create($data);
        $this->messageService->send([
            'message' => 'Novo anexo adicionado ao seu perfil.',
            'user_for' => $data['user_id']
        ]);

        return $data;
    }

    private function update(array $data, int $id): bool
    {
        $repo = $this->find($id);
        $data = $repo->update($data);
        $this->messageService->send([
            'message' => 'Novo anexo editado no seu perfil.',
            'user_for' => $data['user_id']
        ]);

        return $data;
    }

    public function delete(string $id): void
    {
        $repo = $this->find($id);
        $repo->delete();
    }
}
