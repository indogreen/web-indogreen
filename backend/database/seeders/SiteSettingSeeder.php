<?php

namespace Database\Seeders;

use App\Enums\OfficeType;
use App\Models\Office;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSetting::firstOrCreate(
            ['company_name' => 'PT. INDOGREEN TECHNOLOGY AND MANAGEMENT'],
            [
                'tagline' => 'SOLAR ENERGY COMPANY / Konsentrasi kami adalah energy ramah lingkungan',
                'phone' => '+62 251 754 1234',
                'email' => 'marketing@indogreen.id',
                'whatsapp' => '+62 811 1234 5678',
                'head_office_address' => 'Ruko Taman Yasmin Sektor 6 No. 226, Jl. KH. Abdullah Bin Nuh, Bogor Barat, Kota Bogor, Jawa Barat 16113',
                'representative_office_address' => 'Gedung Wisma Bumiputera Lt. 7, Jl. Asia Afrika No. 141-149, Kebon Pisang, Sumur Bandung, Kota Bandung, Jawa Barat 40112',
                'facebook_url' => 'https://facebook.com/indogreen.id',
                'instagram_url' => 'https://instagram.com/indogreen.id',
                'youtube_url' => 'https://youtube.com/@indogreentechnology',
            ]
        );

        Office::firstOrCreate(
            ['name' => 'Kantor Utama Bogor'],
            [
                'office_type' => OfficeType::HEAD_OFFICE,
                'address' => 'Ruko Taman Yasmin Sektor 6 No. 226, Jl. KH. Abdullah Bin Nuh, Bogor Barat, Kota Bogor, Jawa Barat 16113',
                'phone' => '+62 251 754 1234',
                'email' => 'bogor@indogreen.id',
                'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.4!2d106.77!3d-6.55!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMzMnMDAuMCJTIDEwNsKwNDYnMTIuMCJF!5e0!3m2!1sid!2sid!4v1',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        Office::firstOrCreate(
            ['name' => 'Kantor Perwakilan Bandung'],
            [
                'office_type' => OfficeType::REPRESENTATIVE_OFFICE,
                'address' => 'Gedung Wisma Bumiputera Lt. 7, Jl. Asia Afrika No. 141-149, Kebon Pisang, Sumur Bandung, Kota Bandung, Jawa Barat 40112',
                'phone' => '+62 22 420 5678',
                'email' => 'bandung@indogreen.id',
                'map_embed_url' => null,
                'sort_order' => 2,
                'is_active' => true,
            ]
        );
    }
}
