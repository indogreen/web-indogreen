<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\SiteSettingResource;
use App\Models\SiteSetting;
use App\Services\ContentCacheService;
use Illuminate\Http\JsonResponse;

class SettingController extends BaseApiController
{
    /**
     * Get company profile and site settings.
     */
    public function index(): JsonResponse
    {
        $setting = ContentCacheService::remember('site_settings', [], function () {
            return SiteSetting::first() ?? new SiteSetting;
        });

        return $this->respondOk(new SiteSettingResource($setting), 'Data profil dan pengaturan situs berhasil diambil.');
    }
}
