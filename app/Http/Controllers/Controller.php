<?php

namespace App\Http\Controllers;

abstract class Controller
{
    const http_success_code = 200;
    const http_invalid_data = 422;
    const http_internal_code = 500;

    protected function response($data, $code = self::http_success_code)
    {
        return response()->json($data, $code);
    }
}
