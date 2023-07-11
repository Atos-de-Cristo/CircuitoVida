<?php
namespace App\Services;

use App\Models\Forum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ForumService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new Forum();
    }

    public function list(int $lessonId): Collection
    {
        return $this->repository
            ->where('lesson_id', $lessonId)
            ->with('userSend')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function send(string $msn, int $lessonId): Forum
    {
        return $this->repository->create([
            'user_id' => Auth::user()->id,
            'lesson_id' => $lessonId,
            'message' => $msn
        ]);
    }
}
