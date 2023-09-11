<?php
namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;

class AuditService
{
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
