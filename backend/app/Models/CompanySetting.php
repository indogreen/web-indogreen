<?php

namespace App\Models;

use Database\Factories\CompanySettingFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CompanySetting extends Model implements HasMedia
{
    /** @use HasFactory<CompanySettingFactory> */
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'key_name',
        'value_content',
        'value_type',
        'group_type',
        'is_public',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }

    /**
     * Scope query to public settings.
     *
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopePublic(Builder $query): Builder
    {
        return $query->where($this->qualifyColumn('is_public'), true);
    }

    /**
     * Scope query by group type.
     *
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeGroup(Builder $query, string $group): Builder
    {
        return $query->where($this->qualifyColumn('group_type'), $group);
    }

    /**
     * Register media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('hero_desktop')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('hero_mobile')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    /**
     * Register media conversions.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->nonQueued()
            ->width(200)
            ->height(200)
            ->format('webp');

        $this->addMediaConversion('card')
            ->nonQueued()
            ->width(600)
            ->height(600)
            ->format('webp');

        $this->addMediaConversion('hero')
            ->nonQueued()
            ->width(1920)
            ->height(1080)
            ->format('webp');
    }
}
