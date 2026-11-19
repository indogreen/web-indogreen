<?php

namespace App\Models;

use App\Enums\InquiryStatus;
use Database\Factories\InquiryFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inquiry extends Model
{
    /** @use HasFactory<InquiryFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'phone_whatsapp',
        'company_organization',
        'product_id',
        'solution_id',
        'subject',
        'message_content',
        'status',
        'ip_address',
        'user_agent',
        'internal_notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => InquiryStatus::class,
        ];
    }

    /**
     * Scope query by status.
     *
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeWithStatus(Builder $query, InquiryStatus|string $status): Builder
    {
        $statusValue = $status instanceof InquiryStatus ? $status->value : $status;

        return $query->where($this->qualifyColumn('status'), $statusValue);
    }

    /**
     * Inquiry may belong to a product.
     *
     * @return BelongsTo<Product, $this>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Inquiry may belong to a solution.
     *
     * @return BelongsTo<Solution, $this>
     */
    public function solution(): BelongsTo
    {
        return $this->belongsTo(Solution::class);
    }
}
