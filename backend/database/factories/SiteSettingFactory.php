<?php

namespace Database\Factories;

use App\Models\SiteSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SiteSetting>
 */
class SiteSettingFactory extends Factory
{
    protected $model = SiteSetting::class;

    public function definition(): array
    {
        return [
            'company_name' => 'PT. INDOGREEN TECHNOLOGY AND MANAGEMENT',
            'tagline' => 'SOLAR ENERGY COMPANY / Konsentrasi kami adalah energy ramah lingkungan',
            'phone' => '+62-251-7541749',
            'email' => 'support@indogreen.id',
            'whatsapp' => '+6281234567890',
            'head_office_address' => 'Ruko Taman Yasmin Sektor 6 No. 226, Jl. KH. Abdullah Bin Nuh, Bogor Barat, Kota Bogor, Jawa Barat 16113',
            'representative_office_address' => 'Gedung Gandaria 8, Lantai 9, Gandaria City, Jalan Sultan Iskandar Muda, Kebayoran Lama, Jakarta Selatan 12240',
            'facebook_url' => 'https://facebook.com/IndogreenMarketing',
            'instagram_url' => 'https://www.instagram.com/indogreen_solar',
            'youtube_url' => 'https://youtube.com/playlist?list=PLWVVoZic9QLqikef7Rcrt9PlGgA4drenx',
        ];
    }
}
