<?php
namespace App\Services;

use App\Enums\InscriptionStatus;
use App\Models\Attachment;
use Illuminate\Database\Eloquent\Collection;

class AttachmentService extends BaseService
{
    protected $repository;
    protected $messageService;

    protected $rules = [
        'lesson_id' => 'numeric',
        'event_id' => 'numeric',
        'user_id' => 'numeric',
        'type' => 'required|string',
        'name' => 'required|string',
        'path' => 'required|string',
        'after_class' => 'boolean',
    ];

    public function __construct()
    {
        $this->repository = new Attachment();
        $this->messageService = new MessageService();
    }

    public function getAll(array $filter = []): Collection
    {
        return $this->repository->with('lesson')->where($filter)->get();
    }

    public function getAllCourseActive(int $userId): Collection
    {
        return $this->repository
            ->whereHas('lesson', function($query) use ($userId) {
                $query->whereHas('event', function ($query) use ($userId) {
                    $query->whereHas('inscriptions', function ($query) use ($userId) {
                        $query
                            ->where('status', InscriptionStatus::L->name)
                            ->where('user_id', $userId);
                    });
                });
            })
            ->where('after_class', 1)
            ->with('lesson:id,title')
            ->get();
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
        $dataValidate = $this->validateForm($data);
        $data = $this->repository->create($dataValidate);

        $this->messageService->sendGroup([
            'message' => 'Novo anexo cadastrado em '.$data->lesson->title,
            'list_for' => $data->lesson->event->inscriptions->pluck('user_id')
        ]);

        return $data;
    }

    private function update(array $data, int $id): bool
    {
        $repo = $this->find($id);
        $data = $repo->update($data);

        $this->messageService->sendGroup([
            'message' => 'Anexo modificado em '.$repo->lesson->title,
            'list_for' => $repo->lesson->event->inscriptions->pluck('user_id')
        ]);

        return $data;
    }

    public function delete(string $id): void
    {
        $repo = $this->find($id);
        $repo->delete();
    }
}
