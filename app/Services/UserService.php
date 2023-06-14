<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

class UserService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new User;
    }

    public function getAll(): Collection
    {
        return $this->repository->all();
    }

    public function getMonitors( ): Collection
    {
        return $this->repository->whereHas('permissions', function (Builder $query) {
            $query->where('permission', 'monitor');
        })->get();
    }
    public function getMonitorsFiltered($search): Collection
    {
        return $this->repository->whereHas('permissions', function (Builder $query) use ($search) {
            $query->where('permission', 'monitor')->where('name', 'LIKE', '%' . $search . '%');
        })->get();
    }

    public function paginate($search): LengthAwarePaginator
    {
        return $this->repository
            ->where('name', 'LIKE', '%' . $search . '%')
            ->paginate(12);
    }

    public function find(string $id): User
    {
        return $this->repository->with('inscriptions')->find($id);
    }

    public function create(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->repository->create($data);
        $user->permissions()->sync($data['permissions']);
        return $user;
    }

    public function update(array $data, int $id): void
    {
        $data['password'] = Hash::make($data['password']);
        $repo = $this->find($id);
        $repo->update($data);
        $repo->permissions()->sync($data['permissions']);
    }

    public function delete(string $id): void
    {
        $repo = $this->find($id);
        $repo->delete();
    }

    public function resumeActivity(string $id)
    {
        $ret = [];
        $user = $this->find($id);
        $questionService = new QuestionService;
        foreach ($user->inscriptions as $inscription) {
            $lessons = $inscription->event->lessons;
            $activityCount = 0;
            $responseCount = 0;
            foreach ($lessons as $lesson) {
                $activityCount += $lesson->activities->count();

                $activities = $lesson->activities;
                foreach ($activities as $activity) {
                    $questionData = $questionService->getAll($activity->id, $user->id);
                    if (isset($questionData[0]['response'])) {
                        $responseCount++;
                    }
                }
            }
            $ret[$inscription->event_id] = $responseCount.'/'.$activityCount;
        }
        return $ret;
    }

    public function getUsersQuestions(array $questions)
    {
        return $this->repository
            ->whereHas('responses', function (Builder $query) use ($questions) {
                $query->whereIn('question_id', $questions);
            })
            ->with('responses')
            ->withCount(['responses as respostas_pendente' => function ($query) use ($questions) {
                $query->whereIn('question_id', $questions);
                $query->where('status', 'pendente');
            }])
            ->withCount(['responses as respostas_correta' => function ($query) use ($questions) {
                $query->whereIn('question_id', $questions);
                $query->where('status', 'correto');
            }])
            ->withCount(['responses as respostas_errado' => function ($query) use ($questions) {
                $query->whereIn('question_id', $questions);
                $query->where('status', 'errado');
            }])
            ->get();
    }
}
