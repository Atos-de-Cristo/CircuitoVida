<?php
namespace App\Services;

use App\Enums\EventStatus;
use App\Models\Event;
use App\Models\Module;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class EventService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new Event();
    }

    public function getAll(array $filter = []): Collection
    {
        return $this->repository
                ->with('inscriptions')
                ->when(array_key_exists('name', $filter), function ($query) use ($filter) {
                    return $query->where('name', 'like', '%' . $filter['name'] . '%');
                })
                ->when(!array_key_exists('name', $filter), function ($query) use ($filter) {
                    return $query->where($filter);
                })
                ->get();
    }

    public function countActivityCourse(): int
    {
        return $this->repository
                ->where('status', '!=', EventStatus::F->name)
                ->count();
    }

    public function getLessonsWithCounts(array $filter = []): Collection
    {
        return $this->repository
            ->with('inscriptions')
            ->with('lessons')
            ->withCount('lessons')
            ->withCount(['inscriptions' => function ($query) {
                $query->where('status', 'L');
            }, 'lessons'])
            ->where($filter)
            ->get();
    }

    public function listActive(): Collection
    {
        return $this->repository
            ->with('inscriptions')
            ->where('status', '!=', EventStatus::P->name)
            ->where('status', '!=', EventStatus::F->name)
            ->where('end_date', '>', Carbon::now())
            ->get();
    }

    public function paginateOld($search, $sortBy, $sortDirection): LengthAwarePaginator
    {
        return $this->repository
            ->where('name', 'LIKE', '%' . $search . '%')
            ->where('end_date', '<', Carbon::now())
            ->orderBy($sortBy, $sortDirection)
            ->paginate(12);
    }

    public function paginate($search, $sortBy, $sortDirection): LengthAwarePaginator
    {
        return $this->repository
            ->where('name', 'LIKE', '%' . $search . '%')
            ->where('end_date', '>', Carbon::now())
            ->orderBy($sortBy, $sortDirection)
            ->paginate(12);
    }

    public function find(string $id): Event
    {
        return $this->repository->with('monitors', 'modules.lessons.activities', 'attachments')->find($id);
    }

    public function findBasic(string $id): Event
    {
        return $this->repository
            ->with([
                'monitors', 
                'modules' => function($query) {
                    $query->orderBy('name');
                },
                'attachments' => function($query) {
                    $query->orderBy('created_at', 'desc');
                }
            ])
            ->find($id);
    }

    public function copyCourseData($data): bool
    {
        try {
            $modules = Module::where('event_id', $data['course'])->get();

            DB::beginTransaction();

            foreach ($modules as $modulo) {
                $newModulo = $modulo->replicate();
                $newModulo->event_id = $data['event_id'];
                $newModulo->save();

                foreach ($modulo->lessons as $lesson) {
                    $newLesson = $lesson->replicate();
                    $newLesson->module_id = $newModulo->id;
                    $newLesson->event_id = $data['event_id'];
                    $newLesson->save();

                    foreach ($lesson->attachments as $attachment) {
                        $newAttachment = $attachment->replicate();
                        $newAttachment->lesson_id = $newLesson->id;
                        $newAttachment->save();
                    }

                    foreach ($lesson->activities as $activity) {
                        $newActivity = $activity->replicate()->fill(['type', 'G']);
                        $newActivity->lesson_id = $newLesson->id;
                        $newActivity->save();

                        foreach ($activity->questions as $question) {
                            $newQuestion = $question->replicate();
                            $newQuestion->activity_id = $newActivity->id;
                            $newQuestion->save();
                        }
                    }
                }
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function store(array $data): Event | bool
    {
        if (isset($data['id']) && !empty($data['id'])) {
            return $this->update($data, $data['id']);
        }
        return $this->create($data);
    }

    private function create(array $data): Event
    {
        $create = $this->repository->updateOrCreate($data);
        if (isset($data['monitors'])) {
            $create->users()->sync($data['monitors']);
        }
        return $create;
    }

    private function update(array $data, int $id): bool
    {
        $repo = $this->find($id);
        if (isset($data['monitors'])) {
            if (empty($data['monitors'])) {
                $repo->monitors()->detach();
            } else {
                $repo->monitors()->sync($data['monitors']);
            }
        }
        return $repo->update($data);
    }

    public function delete(string $id): void
    {
        //TODO: travando delete até confirmacao de acao
        // throw new Error('Serviço indisponível!');
        $repo = $this->find($id);
        $repo->delete();
    }
}
