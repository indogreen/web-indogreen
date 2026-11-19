<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class HealthController extends BaseApiController
{
    /**
     * System uptime and service health check.
     */
    public function index(): JsonResponse
    {
        $dbStatus = 'CONNECTED';
        try {
            DB::connection()->getPdo();
        } catch (Throwable) {
            $dbStatus = 'DISCONNECTED';
        }

        $storageStatus = 'WRITABLE';
        try {
            Storage::disk('local')->put('.healthcheck', 'ok');
            Storage::disk('local')->delete('.healthcheck');
        } catch (Throwable) {
            $storageStatus = 'UNWRITABLE';
        }

        $isUp = ($dbStatus === 'CONNECTED' && $storageStatus === 'WRITABLE');

        return response()->json([
            'success' => $isUp,
            'status' => $isUp ? 'UP' : 'DOWN',
            'timestamp' => now()->toIso8601String(),
            'services' => [
                'database' => $dbStatus,
                'storage' => $storageStatus,
            ],
        ], $isUp ? 200 : 503);
    }
}
