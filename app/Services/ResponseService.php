<?php
namespace App\Services;

use App\Models\Response;
use Illuminate\Database\Eloquent\Collection;

class ResponseService extends BaseService
{
    protected $repository;

    protected $rules = [
        'user_id' => 'required|numeric',
        'question_id' => 'required|numeric',
        'response' => 'required|min:1',
        'status' => 'required'
    ];

    public function __construct()
    {
        $this->repository = new Response();
    }

    public function getAll(string $questionId): Collection
    {
        return $this->repository
            ->with('user', 'question')
            ->whereRelation('question', 'id', $questionId)
            ->get();
    }

    public function find(string $id): Response
    {
        return $this->repository->with('user', 'question')->find($id);
    }

    public function store(array $data): Response | bool
    {
        $id = $data['id'];
        $dataValidate = $this->validateForm($data);

        if (isset($id) && !empty($id)) {
            return $this->update($dataValidate, $id);
        }
        return $this->create($dataValidate);
    }

    private function create(array $data): Response
    {
        return $this->repository->create($data);
    }

    private function update(array $data, int $id): bool
    {
        $repo = $this->find($id);
        return $repo->update($data);
    }

    public function getUserQuestionResponse(string $idUser, string $activityId)
    {
        return $this->repository
            ->where('user_id', $idUser)
            ->whereRelation('question', 'activity_id', $activityId)
            ->with('question', 'user')
            ->get();
    }
}
