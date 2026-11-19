<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class ContentCacheService
{
    protected const VERSION_KEY = 'content_version';

    protected const DEFAULT_TTL = 300; // 5 menit

    /**
     * Get current content version.
     */
    public static function getVersion(): int
    {
        return (int) Cache::rememberForever(self::VERSION_KEY, fn () => 1);
    }

    /**
     * Bump content version to invalidate all versioned caches.
     */
    public static function bumpVersion(): int
    {
        if (! Cache::has(self::VERSION_KEY)) {
            Cache::forever(self::VERSION_KEY, 1);
        }

        return (int) Cache::increment(self::VERSION_KEY);
    }

    /**
     * Build versioned cache key.
     *
     * @param  array<string, mixed>  $params
     */
    public static function makeKey(string $prefix, array $params = []): string
    {
        $version = self::getVersion();
        $paramHash = md5(json_encode($params) ?: '');

        return "api_v1_{$prefix}_v{$version}_{$paramHash}";
    }

    /**
     * Cache or retrieve data with versioned key.
     *
     * @param  array<string, mixed>  $params
     */
    public static function remember(string $prefix, array $params, \Closure $callback, int $ttl = self::DEFAULT_TTL): mixed
    {
        $key = self::makeKey($prefix, $params);

        return Cache::remember($key, $ttl, $callback);
    }
}
