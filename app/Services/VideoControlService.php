<?php
namespace App\Services;

use App\Models\VideoControl;
use Illuminate\Database\Eloquent\Collection;

class VideoControlService extends BaseService
{
    protected $rules = [
        'user_id' => 'required|numeric',
        'lesson_id' => 'required|numeric',
        'time_start' => 'numeric',
        'time_end' => 'numeric',
        'time_assisted' => 'numeric',
        'time_video' => 'numeric',
    ];

    public function __construct()
    {
        $this->repository = new VideoControl();
    }

    public function getAll(string $questionId): Collection
    {
        return $this->repository
            ->with('user', 'question')
            ->whereRelation('question', 'id', $questionId)
            ->get();
    }

    public function find(string $id): VideoControl
    {
        return $this->repository->with('user', 'question')->find($id);
    }

    public function store(array $data): VideoControl | bool
    {
        $id = $data['id'] ?? null;

        if (isset($id) && !empty($id)) {
            //TODO: verificar validacao update
            return $this->update($data, $id);
        }

        $dataValidate = $this->validateForm($data);
        return $this->create($dataValidate);
    }

    private function create(array $data): VideoControl
    {
        return $this->repository->firstOrCreate($data);
    }

    private function update(array $data, int $id): bool
    {
        $repo = $this->repository->find($id);
        return $repo->update($data);
    }
}
