<?php
namespace App\Services;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

class PermissionService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new Permission;
    }

    public function getAll()
    {
        return $this->repository->getAllFromCache();
    }

    public function find(string $name): Permission
    {
        return $this->repository->getPermission($name);
    }
}
