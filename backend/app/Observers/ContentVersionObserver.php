<?php

namespace App\Observers;

use App\Services\ContentCacheService;
use Illuminate\Database\Eloquent\Model;

class ContentVersionObserver
{
    /**
     * Handle the Model "saved" event.
     */
    public function saved(Model $model): void
    {
        ContentCacheService::bumpVersion();
    }

    /**
     * Handle the Model "deleted" event.
     */
    public function deleted(Model $model): void
    {
        ContentCacheService::bumpVersion();
    }

    /**
     * Handle the Model "restored" event.
     */
    public function restored(Model $model): void
    {
        ContentCacheService::bumpVersion();
    }
}
