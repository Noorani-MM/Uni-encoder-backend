<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    public function message(string $message = '', object|array $data = [], object|array $errors = [], bool $success = true, int $status = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data'    => $data,
            'errors'  => $errors,
            'success' => $success,
        ], $status);
    }

    public function success(string $message = '', object|array $data = []): JsonResponse
    {
        return $this->message($message, $data);
    }

    public function errors(string $message = '', object|array $errors = [], int $status = 200): JsonResponse
    {
        return $this->message($message, [], $errors, false, $status);
    }
}
