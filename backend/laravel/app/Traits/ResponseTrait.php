<?php

namespace App\Traits;

trait ResponseTrait
{
    /**
     * Response success
     * @param string $message
     * @return array
     */
    protected function success($message)
    {
        return [
            'success' => true,
            'message' => $message
        ];
    }

    /**
     * Response error
     * @param string $message
     * @return array
     */
    protected function error($message)
    {
        \Log::info($message);

        return [
            'error' => true,
            'message' => $message
        ];
    }
}