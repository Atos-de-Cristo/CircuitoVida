<?php
namespace App\Services;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ProfileService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new Profile();
    }

    public function find(): array | null
    {
        $data = $this->repository->where('user_id', Auth::user()->id)->first();
        if ($data == null) {
            return null;
        }
        return $data->toArray();
    }

    public function store(array $data): Profile | bool
    {
        $getData = $this->find();
        if ($getData == null) {
            $data['user_id'] = Auth::user()->id;
            return $this->create($data);
        }
        return $this->update($data, $getData['id']);
    }

    private function create(array $data): Profile
    {
        return $this->repository->create($data);
    }

    private function update(array $data, int $id): bool
    {
        $repo = $this->repository->find($id);
        return $repo->update($data);
    }
}
