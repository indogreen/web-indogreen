<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaUrlHelper
{
    /**
     * Format a Spatie Media instance into an array with variants and alt text.
     *
     * @return array<string, string|null>|null
     */
    public static function formatMedia(?Media $media, ?string $fallbackAlt = null): ?array
    {
        if (! $media) {
            return null;
        }

        $alt = (string) ($media->getCustomProperty('alt') ?: $fallbackAlt ?: $media->name);

        return [
            'original' => $media->getFullUrl(),
            'thumb' => $media->hasGeneratedConversion('thumb') ? $media->getFullUrl('thumb') : $media->getFullUrl(),
            'card' => $media->hasGeneratedConversion('card') ? $media->getFullUrl('card') : $media->getFullUrl(),
            'hero' => $media->hasGeneratedConversion('hero') ? $media->getFullUrl('hero') : $media->getFullUrl(),
            'alt' => $alt,
        ];
    }

    /**
     * Format a relative storage path into an array with absolute URLs and alt text.
     *
     * @return array<string, string|null>|null
     */
    public static function formatPath(?string $path, ?string $alt = null): ?array
    {
        if (blank($path)) {
            return null;
        }

        $url = str_starts_with($path, 'http://') || str_starts_with($path, 'https://')
            ? $path
            : Storage::disk('public')->url($path);

        return [
            'original' => $url,
            'thumb' => $url,
            'card' => $url,
            'hero' => $url,
            'alt' => $alt ?? '',
        ];
    }

    /**
     * Format a single file path into an absolute URL.
     */
    public static function formatFileUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        return str_starts_with($path, 'http://') || str_starts_with($path, 'https://')
            ? $path
            : Storage::disk('public')->url($path);
    }
}
