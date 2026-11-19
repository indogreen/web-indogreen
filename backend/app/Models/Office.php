<?php

namespace App\Models;

use App\Enums\OfficeType;
use App\Models\Traits\HasActiveScope;
use App\Models\Traits\HasSortOrderScope;
use Database\Factories\OfficeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property OfficeType $office_type
 */
class Office extends Model
{
    /** @use HasFactory<OfficeFactory> */
    use HasActiveScope, HasFactory, HasSortOrderScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'office_type',
        'address',
        'phone',
        'email',
        'map_embed_url',
        'sort_order',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'office_type' => OfficeType::class,
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
