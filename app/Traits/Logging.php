<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait Logging
{
    /**
     * Logging.
     */
    public function log(string $log_level, string $message, array $data = [])
    {
        Log::channel('daily')->log($log_level, $message, array_merge(['from' => static::class], $data));
    }
}
