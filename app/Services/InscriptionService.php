<?php

namespace App\Services;

use App\Enums\EventStatus;
use App\Models\Inscription;
use Carbon\Carbon;
use Error;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class InscriptionService extends BaseService
{
    protected $repository;

    protected $rules = [
        'event_id' => 'required|numeric',
        'user_id' => 'required|numeric',
        'quantity' => 'required|numeric',
        'amount' => 'required',
        'status' => 'required'
    ];

    public function __construct()
    {
        $this->repository = new Inscription();
    }

    public function getAll(array $filter = []): Collection
    {
        return $this->repository->where($filter)->with('event', 'user')->get();
    }

    public function getInscriptionActive(): array
    {
        $req = $this->repository
            ->with('event.modules.lessons')
            ->where([
                'user_id' => Auth::user()->id,
                'status' => 'L'
            ])
            ->get();

        $lessonActivity = [];
        if ($req->isNotEmpty() && $req->first()->event !== null) {
            $event = $req
                ->first()
                ->event
                    ->where('status', '!=', EventStatus::P->name)
                    ->where('status', '!=', EventStatus::F->name)
                    ->first();
            if ($event !== null && $event->modules !== null) {
                $modules = $event->modules;
                foreach ($modules as $mod) {
                    $lessonActivity[$mod->id]['event_id'] = $req->first()->event->first()->id;
                    $lessonActivity[$mod->id]['event'] = $req->first()->event->first()->name;
                    $lessonActivity[$mod->id]['module'] = $mod->name;

                    foreach ($mod->lessons as $lesson) {
                        if ($lesson->start_date && $lesson->end_date) {
                            if (
                                Carbon::parse($lesson->start_date) <= Carbon::parse(date('Y-m-d H:i:s'))
                                && Carbon::parse($lesson->end_date) > Carbon::parse(date('Y-m-d H:i:s'))
                            ) {
                                $lessonActivity[$mod->id]['lessons'][$lesson->id] = $lesson->toArray();
                            }
                        }else{
                            $lessonActivity[$mod->id]['lessons'][$lesson->id] = $lesson->toArray();
                        }
                    }
                }
            }
        }

        return array_filter($lessonActivity, function ($lesson) {
            if (isset($lesson['lessons']) && !empty($lesson['lessons'])) {
                return $lesson;
            }
        });
    }

    public function getAllStudent($search, $eventId): Collection
    {
        $today = Carbon::now()->toDateString();

        $results = Inscription::where('event_id', $eventId)
            ->with([
                'user' => function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%');
                },
                'event.lessons' => function ($query) use ($today) {
                    $query->where('end_date', '<=', $today);
                },
                'event.lessons.frequency',
                'event.lessons.activities.questions.Response',
            ])
            ->get();

        $results = $results
            ->filter(function ($value) {
                return $value->user != null;
            })
            ->map(function ($item) {
                $totalLessons = $item->event->lessons->count();
                $totalFrequency = 0;
                $statusActivity = [];
                $item->event->lessons->each(function ($lesson) use (&$item, &$totalFrequency, &$statusActivity) {
                    $totalFrequency += $lesson->frequency->where('user_id', $item->user_id)->count();
                    $lesson->activities->each(function ($activity) use (&$item, &$statusActivity, &$lesson) {
                        $totalPendent = 0;
                        $totalCorrect = 0;
                        $totalIncorrect = 0;
                        $notResponse = false;
                        $totalQuestions = $activity->questions->count();

                        $activity->questions->each(function ($question) use (&$item, &$totalPendent, &$totalCorrect, &$totalIncorrect, &$notResponse) {
                            if ($question->response->where('user_id', $item->user_id)->count() <= 0) {
                                $notResponse = true;
                                return;
                            }

                            $totalPendent += $question->response->where('user_id', $item->user_id)->where('status', 'pendente')->count();
                            $totalCorrect += $question->response->where('user_id', $item->user_id)->where('status', 'correto')->count();
                            $totalIncorrect += $question->response->where('user_id', $item->user_id)->where('status', 'errado')->count();
                        });

                        // TODO: melhorar ifs
                        if ($notResponse == false) {
                            $percent = ($totalCorrect/$totalQuestions)*100;
                            if ($percent <= 70 || $totalPendent > 0) {
                                $statusActivity[] = [
                                    'lesson' => $lesson->title,
                                    'activity' => $activity->title,
                                    'pendent' => $totalPendent,
                                    'correct' => $totalCorrect,
                                    'incorrect' => $totalIncorrect,
                                    'percent' => number_format($percent, 2, '.', ''),
                                    'status' => $totalPendent > 0 ? 'Pendentes de correção' : 'Reprovado',
                                    'totalQuestions' => $totalQuestions,
                                ];
                            }
                        }else{
                            $statusActivity[] = [
                                'lesson' => $lesson->title,
                                'activity' => $activity->title,
                                'pendent' => $totalPendent,
                                'correct' => $totalCorrect,
                                'incorrect' => $totalIncorrect,
                                'percent' => 0,
                                'status' => 'Não respondido',
                                'totalQuestions' => $totalQuestions,
                            ];
                        }
                    });
                });
                $item->user->absenceCount = $totalLessons-$totalFrequency;
                $item->user->activityStatus = $statusActivity;
                return $item;
            });

        return $results;
    }

    public function getFrequency(string $eventId): Collection
    {
        return $this->repository
            ->with('event', 'user', 'frequencies')
            ->where('inscriptions.event_id', $eventId)
            ->get();
    }

    public function find(string $id): Inscription
    {
        return $this->repository->find($id);
    }

    public function create(array $data): Inscription
    {
        // TODO: desativado ate cad de perfil estar 100%
        // if (Auth::user()->profile === null) {
        //     throw new Error('Preencha seu perfil!');
        // }

        $getInsc = $this->repository
            ->where('user_id', $data['user_id'])
            ->where('event_id', $data['event_id'])
            ->count();
        if ($getInsc > 0) {
            throw new Error('Usuário já inscrito!');
        }

        $getInscTotal = $this->repository
            ->where('event_id', $data['event_id'])
            ->count();
        $eventService = new EventService;
        $limitInsc = $eventService->find($data['event_id'])->tickets_limit;
        if ($getInscTotal >= $limitInsc) {
            throw new Error('Vagas esgotadas!');
        }

        $this->validateForm($data);

        return $this->repository->create($data);
    }

    public function update(array $data, int $id): bool
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
