<?php
namespace App\Services;

use App\Models\Inscription;
use Error;
use Illuminate\Database\Eloquent\Collection;

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

    public function find(string $id): Inscription
    {
        return $this->repository->find($id);
    }

    public function create(array $data): Inscription
    {
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
