<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\User;
use Error;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

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

    public function getMonitors(): Collection
    {
        return $this->repository->whereHas('permissions', function (Builder $query) {
            $query->where('permission', 'monitor');
        })->get();
    }

    public function countStudentsActive( ): int
    {
        return $this->repository
        ->whereHas('permissions', function (Builder $query) {
            $query->where('permission', 'aluno');
        })
        ->whereHas('inscriptions', function (Builder $query) {
            $query->where('status', 'L');
        })
        ->whereHas('events', function (Builder $query) {
            $query->where('status', 'E');
        })
        ->count();
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
            ->orWhere('email', 'LIKE', '%' . $search . '%')
            ->paginate(12);
    }

    public function find(string $id): User
    {
        return $this->repository->with('inscriptions','profile')->find($id);
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
        try {
            if (isset($data['password']) && !empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }else{
                unset($data['password']);
            }
            $repo = $this->find($id);
            $repo->update($data);
            $repo->permissions()->sync($data['permissions']);

            Cache::forget('permissions::of::user::'.$repo->id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete(string $id): void
    {
        //TODO: travando delete até confirmacao de acao
        throw new Error('Serviço indisponível!');
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
                $activityCount += $lesson->activities->where('type', 'G')->count();

                $activities = $lesson->activities->where('type', 'G');
                foreach ($activities as $activity) {
                    $questionData = $questionService->getAll($activity->id, $user->id);
                    if (isset($questionData[0]['response'])) {
                        $responseCount++;
                    }
                }
            }
            $ret[$inscription->event_id]['responseCount'] = $responseCount;
            $ret[$inscription->event_id]['activityCount'] = $activityCount;
        }

        return $ret;
    }

    public function getUsersQuestionsResume(array $questions)
    {
        $results = $this->repository
            ->whereHas('responses', function (Builder $query) use ($questions) {
                $query->whereIn('question_id', $questions);
            })
            ->with('responses')
            ->withCount(['responses as pending_answers' => function ($query) use ($questions) {
                $query->whereIn('question_id', $questions);
                $query->where('status', 'pendente');
            }])
            ->withCount(['responses as correct_answers' => function ($query) use ($questions) {
                $query->whereIn('question_id', $questions);
                $query->where('status', 'correto');
            }])
            ->withCount(['responses as wrong_answers' => function ($query) use ($questions) {
                $query->whereIn('question_id', $questions);
                $query->where('status', 'errado');
            }])
            ->orderBy('name', 'asc')
            ->get();

        return $results->map(function ($item) {
            $totalAnswers = $item->correct_answers + $item->wrong_answers;
            $item->status_correct = $totalAnswers > 0;
            $item->correct_percentage = $totalAnswers > 0 ? round(($item->correct_answers / $totalAnswers) * 100, 2) : null;
            return $item;
        });
    }

    public function listIdsEvent($eventId)
    {
        return $this->repository->
        whereHas('inscriptions.event', function ($query) use ($eventId) {
            $query->where('id', $eventId);
        })->pluck('id');
    }
}
