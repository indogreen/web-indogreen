<?php

namespace App\Models;

use Database\Factories\SiteSettingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    /** @use HasFactory<SiteSettingFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'company_name',
        'tagline',
        'phone',
        'email',
        'whatsapp',
        'head_office_address',
        'representative_office_address',
        'facebook_url',
        'instagram_url',
        'youtube_url',
    ];
}
