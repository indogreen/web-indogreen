<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasSortOrderScope
{
    /**
     * Scope a query to order records by sort_order ascending.
     *
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeOrdered(Builder $query, string $direction = 'asc'): Builder
    {
        return $query->orderBy($this->qualifyColumn('sort_order'), $direction);
    }
}
