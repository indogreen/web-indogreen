<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

abstract class BaseApiController extends Controller
{
    /**
     * Return standardized success JSON response envelope.
     *
     * @param  array<string, mixed>|null  $meta
     */
    protected function respondOk(mixed $data = null, string $message = 'Operasi berhasil dieksekusi.', ?array $meta = null, int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'meta' => $meta,
        ], $status);
    }

    /**
     * Return standardized error JSON response envelope.
     *
     * @param  array<string, mixed>|object|null  $errors
     */
    protected function respondError(string $message, string $errorCode = 'BAD_REQUEST', mixed $errors = null, int $status = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error_code' => $errorCode,
            'errors' => $errors ?: new \stdClass,
        ], $status);
    }
}
