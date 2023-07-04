<?php

namespace App\Services;

use App\Models\Inscription;
use Carbon\Carbon;
use Error;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class InscriptionService
{
    protected $repository;

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
            $event = $req->first()->event->where('status', 'A')->first();
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
        return Inscription::where('event_id', $eventId)
            ->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%');
            })
            ->get();
    }

    public function getFrequency(string $eventId, string $lessonId): Collection
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
        if (Auth::user()->profile->count() == 0) {
            throw new Error('Preencha seu perfil!');
        }

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
