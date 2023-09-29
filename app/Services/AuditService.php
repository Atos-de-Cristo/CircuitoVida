<?php
namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\File;
use OwenIt\Auditing\Models\Audit;

class AuditService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new Audit();
    }

    public function getAll(array $filter = []): LengthAwarePaginator
    {
        return $this->repository
            ->query()
            ->with('user')
            ->where(function ($query) use ($filter) {
                $query
                    ->where('event', 'like', '%' . $filter['type'] . '%')
                    ->where('user_id', 'like', '%' . $filter['userId'] . '%')
                    ;
            })
            ->when( $filter['module'], function ($query) use ($filter) {
                $query->where('auditable_type',  $filter['module']);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ;
    }

    public static function getAuditableModels()
    {
        $models = [];

        $directory = app_path('Models');

        foreach (File::allFiles($directory) as $file) {
            $modelNamespace = 'App\\Models\\';
            $modelClass = $modelNamespace . str_replace('.php', '', $file->getFilename());

            if (class_exists($modelClass) && in_array('OwenIt\Auditing\Contracts\Auditable', class_implements($modelClass))) {
                $models[$modelNamespace.class_basename($modelClass)] = class_basename($modelClass);
            }
        }

        return $models;
    }
}
