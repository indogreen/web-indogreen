<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'PJU Tenaga Surya',
                'slug' => 'pju-tenaga-surya',
                'description' => 'Lampu Penerangan Jalan Umum Tenaga Surya dengan sistem Two-In-One (TIO) dan All-In-One (AIO) berdaya tahan tinggi.',
                'icon_name' => 'sun',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'PLTS Residensial',
                'slug' => 'plts-residential',
                'description' => 'TODO-CONTENT: Deskripsi resmi kategori PLTS Residensial menunggu verifikasi manajemen.',
                'icon_name' => 'home',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Solar Home System',
                'slug' => 'solar-home-system',
                'description' => 'TODO-CONTENT: Deskripsi resmi kategori Solar Home System (SHS) menunggu verifikasi manajemen.',
                'icon_name' => 'battery-charging',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Aksesoris Kelistrikan',
                'slug' => 'aksesoris-kelistrikan',
                'description' => 'TODO-CONTENT: Deskripsi resmi kategori Aksesoris Kelistrikan menunggu verifikasi manajemen.',
                'icon_name' => 'plug',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $data) {
            Category::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
