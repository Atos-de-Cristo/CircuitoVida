<?php
namespace App\Services;

use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class QuestionService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new Question();
    }

    public function getAll(string $activityId, string | null $userId = null): Collection
    {
        if ($userId == null) {
            $userId = Auth::user()->id;
        }

        return $this->repository
            ->with('activity')
            ->where('activity_id', $activityId)
            ->leftJoin('responses', function ($join) use ($userId) {
                $join->on('questions.id', '=', 'responses.question_id')
                    ->where('responses.user_id', '=', $userId);
            })
            ->select(
                'questions.*',
                'responses.response AS response',
                'responses.status AS response_status'
            )
            ->get();
    }

    public function getQuestionsCorrect(string $activityId, string | null $userId = null): array
    {
        if ($userId == null) {
            $userId = Auth::user()->id;
        }

        $results = $this->repository
            ->with('activity')
            ->where('activity_id', $activityId)
            ->leftJoin('responses', function ($join) use ($userId) {
                $join->on('questions.id', '=', 'responses.question_id')
                    ->where('responses.user_id', '=', $userId);
            })
            ->select(
                'questions.*',
                'responses.response AS response',
                'responses.status AS response_status'
            )
            ->get();

        $checkResponse = false;
        $answers_correct = 0;
        $answers_wrong = 0;
        $answers_pending = 0;

        foreach ($results as $result) {
            if ($checkResponse == false && isset($result->response_status)) {
                $checkResponse = true;
            }

            $answers_correct = ($result->response_status == 'correto') ? $answers_correct + 1 : $answers_correct;
            $answers_wrong = ($result->response_status == 'errado') ? $answers_wrong + 1 : $answers_wrong;
            $answers_pending = ($result->response_status == 'pendente') ? $answers_pending + 1 : $answers_pending;
        }

        $totalAnswers = $answers_correct + $answers_wrong;
        $checkCorrect = ($answers_pending > 0) ? 'Pendente de correção' : round(($answers_correct / $totalAnswers) * 100, 2).'%';

        return [
            'data' => $results,
            'correct' => $checkCorrect,
            'checkResponse' => $checkResponse
        ];
    }

    public function find(string $id): Question
    {
        return $this->repository->with('activity')->find($id);
    }

    public function store(array $data): Question | bool
    {
        if (isset($data['id'])) {
            return $this->update($data, $data['id']);
        }
        return $this->create($data);
    }

    private function create(array $data): Question
    {
        $processedOptions = collect($data['options'])->map(function ($option) {
            return [
                'text' => $option['text'],
                'correct' => $option['correct'],
            ];
        });
        $data['options'] = $processedOptions->toJson();
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
