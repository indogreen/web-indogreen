<?php

namespace App\Models;

use App\Models\Traits\HasActiveScope;
use App\Models\Traits\HasSlug;
use App\Models\Traits\HasSortOrderScope;
use App\Services\HtmlSanitizerService;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    /** @use HasFactory<ProductFactory> */
    use HasActiveScope, HasFactory, HasSlug, HasSortOrderScope, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'model_series',
        'badge_tag',
        'short_description',
        'full_description',
        'seo_title',
        'seo_description',
        'featured_image',
        'datasheet_pdf',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Sanitize full_description before saving.
     *
     * @return Attribute<string|null, string|null>
     */
    protected function fullDescription(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => HtmlSanitizerService::sanitize($value),
        );
    }

    /**
     * Scope a query to only include featured products.
     *
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where($this->qualifyColumn('is_featured'), true);
    }

    /**
     * Product belongs to a Category.
     *
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Product has many specifications.
     *
     * @return HasMany<ProductSpecification, $this>
     */
    public function specifications(): HasMany
    {
        return $this->hasMany(ProductSpecification::class)->orderBy('sort_order', 'asc');
    }

    /**
     * Product has many inquiries.
     *
     * @return HasMany<Inquiry, $this>
     */
    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }

    /**
     * Product can be associated with many Solutions.
     *
     * @return BelongsToMany<Solution, $this>
     */
    public function solutions(): BelongsToMany
    {
        return $this->belongsToMany(Solution::class, 'product_solution')
            ->withPivot('sort_order')
            ->orderByPivot('sort_order', 'asc');
    }

    /**
     * Register media collections for product.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('hero_desktop')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('hero_mobile')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('product_gallery')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('product_datasheet')
            ->singleFile()
            ->acceptsMimeTypes(['application/pdf']);
    }

    /**
     * Register media conversions for product.
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
