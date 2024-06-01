<?php

namespace App\Services;

use App\Traits\Logging;
use Illuminate\Support\Facades\Validator;

abstract class BaseService
{
    use Logging;

    /**
     * validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Validate request input.
     */
    public function validate(array $params)
    {
        Validator::make($params, $this->rules())->validate();

        return true;
    }
}
