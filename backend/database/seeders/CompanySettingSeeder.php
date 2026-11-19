<?php

namespace Database\Seeders;

use App\Enums\OfficeType;
use App\Models\CompanySetting;
use Illuminate\Database\Seeder;

class CompanySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Identitas Korporat
            [
                'key_name' => 'company_name',
                'value_content' => 'PT. INDOGREEN TECHNOLOGY AND MANAGEMENT',
                'value_type' => 'text',
                'group_type' => 'general',
                'is_public' => true,
            ],
            [
                'key_name' => 'company_tagline',
                'value_content' => 'SOLAR ENERGY COMPANY / Konsentrasi kami adalah energy ramah lingkungan',
                'value_type' => 'text',
                'group_type' => 'general',
                'is_public' => true,
            ],
            [
                'key_name' => 'company_description',
                'value_content' => 'PT. INDOGREEN TECHNOLOGY AND MANAGEMENT adalah perusahaan yang bergerak dalam pembangunan dan pengembangan Energi Baru dan Terbarukan (EBT) di Indonesia. Kami secara khusus menyediakan produk dan system dengan kualitas terbaik dan memberikan layanan purna jual yang berorientasi pada kepuasan konsumen.',
                'value_type' => 'text',
                'group_type' => 'general',
                'is_public' => true,
            ],

            // Kontak & Lokasi
            [
                'key_name' => 'head_office_type',
                'value_content' => OfficeType::HEAD_OFFICE->value,
                'value_type' => 'text',
                'group_type' => 'contact',
                'is_public' => true,
            ],
            [
                'key_name' => 'head_office_address',
                'value_content' => 'Ruko Taman Yasmin Sektor 6 No. 226, Jl. KH. Abdullah Bin Nuh, Bogor Barat, Kota Bogor, Jawa Barat 16113',
                'value_type' => 'text',
                'group_type' => 'contact',
                'is_public' => true,
            ],
            [
                'key_name' => 'head_office_phone',
                'value_content' => '+62-251-7541749',
                'value_type' => 'text',
                'group_type' => 'contact',
                'is_public' => true,
            ],
            [
                'key_name' => 'support_email',
                'value_content' => 'support@indogreen.id',
                'value_type' => 'text',
                'group_type' => 'contact',
                'is_public' => true,
            ],
            [
                'key_name' => 'representative_office_type',
                'value_content' => OfficeType::REPRESENTATIVE_OFFICE->value,
                'value_type' => 'text',
                'group_type' => 'contact',
                'is_public' => true,
            ],
            [
                'key_name' => 'representative_office_address',
                'value_content' => 'Gedung Gandaria 8, Lantai 9, Gandaria City, Jalan Sultan Iskandar Muda, Kebayoran Lama, Jakarta Selatan 12240',
                'value_type' => 'text',
                'group_type' => 'contact',
                'is_public' => true,
            ],

            // Media Sosial
            [
                'key_name' => 'social_facebook',
                'value_content' => 'https://facebook.com/IndogreenMarketing',
                'value_type' => 'text',
                'group_type' => 'social',
                'is_public' => true,
            ],
            [
                'key_name' => 'social_instagram',
                'value_content' => 'https://www.instagram.com/indogreen_solar',
                'value_type' => 'text',
                'group_type' => 'social',
                'is_public' => true,
            ],
            [
                'key_name' => 'social_youtube',
                'value_content' => 'https://youtube.com/playlist?list=PLWVVoZic9QLqikef7Rcrt9PlGgA4drenx',
                'value_type' => 'text',
                'group_type' => 'social',
                'is_public' => true,
            ],

            // Placeholders TODO-CONTENT
            [
                'key_name' => 'whatsapp_number',
                'value_content' => 'TODO-CONTENT: Menunggu verifikasi nomor WhatsApp hotline resmi PT. Indogreen',
                'value_type' => 'text',
                'group_type' => 'contact',
                'is_public' => true,
            ],
            [
                'key_name' => 'stats_kwp_installed',
                'value_content' => 'TODO-CONTENT: Menunggu angka resmi kapasitas terpasang (kWp)',
                'value_type' => 'text',
                'group_type' => 'stats',
                'is_public' => true,
            ],
            [
                'key_name' => 'stats_pju_points',
                'value_content' => 'TODO-CONTENT: Menunggu verifikasi jumlah titik PJU terpasang',
                'value_type' => 'text',
                'group_type' => 'stats',
                'is_public' => true,
            ],
            [
                'key_name' => 'stats_warranty_years',
                'value_content' => 'TODO-CONTENT: Menunggu verifikasi durasi garansi resmi',
                'value_type' => 'text',
                'group_type' => 'stats',
                'is_public' => true,
            ],
        ];

        foreach ($settings as $setting) {
            CompanySetting::updateOrCreate(
                ['key_name' => $setting['key_name']],
                $setting
            );
        }
    }
}
