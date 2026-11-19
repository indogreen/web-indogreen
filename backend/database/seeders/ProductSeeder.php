<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSpecification;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pjuCategory = Category::where('slug', 'pju-tenaga-surya')->first();

        if (! $pjuCategory) {
            return;
        }

        $products = [
            [
                'category_id' => $pjuCategory->id,
                'name' => 'PJU Two-In-One Helios Series',
                'slug' => 'pju-two-in-one-helios-series',
                'model_series' => 'TIO-HELIOS',
                'badge_tag' => 'POPULAR',
                'short_description' => 'Luminer PJU solar Two-In-One seri Helios dengan efisiensi modul surya tinggi dan baterai LiFePO4 terintegrasi.',
                'full_description' => 'PJU Two-In-One Helios Series dirancang khusus untuk jalan arteri, jalan protokol, dan kawasan industri dengan efisiensi pencahayaan superior. TODO-CONTENT: Detail deskripsi lengkap teknis.',
                'featured_image' => 'products/pju-two-in-one-helios-series.webp',
                'datasheet_pdf' => 'datasheets/pju-two-in-one-helios-series.pdf',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
                'specs' => [
                    ['spec_group' => 'Elektrikal', 'spec_key' => 'Daya Lampu LED', 'spec_value' => '60 - 120', 'spec_unit' => 'W', 'sort_order' => 1],
                    ['spec_group' => 'Elektrikal', 'spec_key' => 'Efikasi Cahaya', 'spec_value' => '160 - 180', 'spec_unit' => 'lm/W', 'sort_order' => 2],
                    ['spec_group' => 'Baterai', 'spec_key' => 'Tipe Baterai', 'spec_value' => 'LiFePO4 Lithium Iron Phosphate', 'spec_unit' => null, 'sort_order' => 3],
                    ['spec_group' => 'Mekanikal', 'spec_key' => 'Ketahanan Proteksi', 'spec_value' => 'IP66 / IK08', 'spec_unit' => null, 'sort_order' => 4],
                ],
            ],
            [
                'category_id' => $pjuCategory->id,
                'name' => 'PJU Two-In-One Jupiter Series',
                'slug' => 'pju-two-in-one-jupiter-series',
                'model_series' => 'TIO-JUPITER',
                'badge_tag' => 'SERI TIO',
                'short_description' => 'Lampu PJU Two-In-One seri Jupiter untuk jalan kolektor dan area perumahan modern dengan sensor cerdas.',
                'full_description' => 'TODO-CONTENT: Deskripsi lengkap PJU Two-In-One Jupiter Series.',
                'featured_image' => 'products/pju-two-in-one-jupiter-series.webp',
                'datasheet_pdf' => 'datasheets/pju-two-in-one-jupiter-series.pdf',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 2,
                'specs' => [
                    ['spec_group' => 'Elektrikal', 'spec_key' => 'Daya Lampu LED', 'spec_value' => '40 - 80', 'spec_unit' => 'W', 'sort_order' => 1],
                    ['spec_group' => 'Baterai', 'spec_key' => 'Tipe Baterai', 'spec_value' => 'LiFePO4', 'spec_unit' => null, 'sort_order' => 2],
                ],
            ],
            [
                'category_id' => $pjuCategory->id,
                'name' => 'PJU Two-In-One Mars Series',
                'slug' => 'pju-two-in-one-mars-series',
                'model_series' => 'TIO-MARS',
                'badge_tag' => 'SERI TIO',
                'short_description' => 'Penerangan jalan bertenaga surya Two-In-One seri Mars berdaya tahan cuaca ekstrem dan instalasi praktis.',
                'full_description' => 'TODO-CONTENT: Deskripsi lengkap PJU Two-In-One Mars Series.',
                'featured_image' => 'products/pju-two-in-one-mars-series.webp',
                'datasheet_pdf' => 'datasheets/pju-two-in-one-mars-series.pdf',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 3,
                'specs' => [
                    ['spec_group' => 'Elektrikal', 'spec_key' => 'Daya Lampu LED', 'spec_value' => '30 - 60', 'spec_unit' => 'W', 'sort_order' => 1],
                ],
            ],
            [
                'category_id' => $pjuCategory->id,
                'name' => 'PJU All-In-One Mars Series',
                'slug' => 'pju-all-in-one-mars-series',
                'model_series' => 'AIO-MARS',
                'badge_tag' => 'ALL IN ONE',
                'short_description' => 'Sistem PJU All-In-One terpadu yang memadukan panel surya, baterai, sensor gerak, dan lampu dalam satu bodi ringkas.',
                'full_description' => 'TODO-CONTENT: Deskripsi lengkap PJU All-In-One Mars Series.',
                'featured_image' => 'products/pju-all-in-one-mars-series.webp',
                'datasheet_pdf' => 'datasheets/pju-all-in-one-mars-series.pdf',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 4,
                'specs' => [
                    ['spec_group' => 'Elektrikal', 'spec_key' => 'Daya Lampu LED', 'spec_value' => '30 - 100', 'spec_unit' => 'W', 'sort_order' => 1],
                    ['spec_group' => 'Desain', 'spec_key' => 'Integrasi Sistem', 'spec_value' => 'All-In-One Integrated Monocrystalline & LiFePO4', 'spec_unit' => null, 'sort_order' => 2],
                ],
            ],
        ];

        foreach ($products as $item) {
            $specs = $item['specs'];
            unset($item['specs']);

            $product = Product::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );

            // Re-sync specifications
            ProductSpecification::where('product_id', $product->id)->delete();
            foreach ($specs as $spec) {
                $spec['product_id'] = $product->id;
                ProductSpecification::create($spec);
            }
        }
    }
}
