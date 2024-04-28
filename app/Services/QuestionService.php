<?php
namespace App\Services;

use App\Models\Question;
use Error;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class QuestionService extends BaseService
{
    protected $repository;

    protected $rules = [
        'activity_id' => 'required|numeric',
        'type' => 'required',
        'title' => 'required',
        'options' => 'array'
    ];

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

    public function getAllId(string $activityId)
    {
        return $this->repository
            ->where('activity_id', $activityId)
            ->pluck('id');
    }

    public function getQuestionsCorrect(string $activityId, ?string $userId = null): array
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

        $checkResponse = isset($results->first()->response_status);
        $answersCorrect = $results->where('response_status', 'correto')->count();
        $answersWrong = $results->where('response_status', 'errado')->count();
        $answersPending = $results->where('response_status', 'pendente')->count();

        $totalAnswers = $answersCorrect + $answersWrong;
        $checkCorrect = ($totalAnswers > 0) ? round(($answersCorrect / $totalAnswers) * 100, 2).'%' : 'Pendente correção!';

        if ($answersPending > 0) {
            $checkCorrect = 'Pendente correção!';
        }

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

        $dataValidate = $this->validateForm($data);
        return $this->create($dataValidate);
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
        //TODO: travando delete até confirmacao de acao
        throw new Error('Serviço indisponível!');
        $repo = $this->find($id);
        $repo->delete();
    }
}
