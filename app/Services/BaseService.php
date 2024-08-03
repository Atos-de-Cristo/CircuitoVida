<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BaseService
{
    protected $rules;
    protected $repository;

    protected function validateForm(array $data, int $id = null): array
    {
        $validator = Validator::make($data, $this->rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
