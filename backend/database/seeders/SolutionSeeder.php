<?php

namespace Database\Seeders;

use App\Models\Solution;
use Illuminate\Database\Seeder;

class SolutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $solutions = [
            [
                'name' => 'PLTS On-Grid',
                'slug' => 'plts-on-grid',
                'system_type' => 'On-Grid',
                'summary' => 'Sistem pembangkit listrik tenaga surya tersinkronisasi jaringan PLN untuk efisiensi biaya listrik operasional.',
                'system_architecture' => 'Aliran daya surya dari modul PV dikonversi oleh grid-tie inverter menjadi arus AC yang langsung menyuplai beban gedung/rumah. Surplus daya diekspor ke jaringan PLN melalui kWh meter ekspor-impor (Net Metering). TODO-CONTENT: Diagram sistem lengkap.',
                'included_components' => [
                    'Modul Panel Surya Tier-1 (Monocrystalline)',
                    'On-Grid Inverter String / Central',
                    'Aluminium Mounting Bracket & Clamp',
                    'Panel Distribusi AC & DC Disconnect Switch',
                    'Surge Protection Device (SPD) Type II',
                ],
                'benefits' => [
                    'Penghematan tagihan listrik PLN bulanan hingga 30-70%',
                    'Bebas biaya perawatan baterai (tanpa komponen baterai)',
                    'Pengembalian investasi (ROI) terukur 4-6 tahun',
                    'Pemantauan performa produksi daya secara real-time via smartphone',
                ],
                'diagram_image' => 'solutions/plts-on-grid.webp',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'PLTS On-Grid Hybrid',
                'slug' => 'plts-on-grid-hybrid',
                'system_type' => 'Hybrid',
                'summary' => 'Sistem tersinkronisasi jaringan PLN yang dilengkapi baterai cadangan guna menjamin suplai daya saat terjadi pemadaman listrik.',
                'system_architecture' => 'Menggabungkan keunggulan sistem On-Grid dengan fleksibilitas baterai penyimpanan lithium. Saat PLN normal, energi surya menyuplai beban dan mengisi baterai. Saat PLN padam, sistem beralih otomatis ke baterai tanpa jeda (seamless transfer). TODO-CONTENT: Diagram arsitektur.',
                'included_components' => [
                    'Modul Panel Surya Monocrystalline Efisiensi Tinggi',
                    'Hybrid Inverter Interaktif Cerdas',
                    'Bank Baterai Lithium Iron Phosphate (LiFePO4)',
                    'Automatic Transfer Switch (ATS)',
                    'Sistem Manajemen Baterai (BMS) Terpadu',
                ],
                'benefits' => [
                    'Jaminan listrik tetap menyala saat jaringan PLN padam',
                    'Efisiensi biaya listrik bulanan optimal',
                    'Masa pakai baterai LiFePO4 hingga 10+ tahun (6000 siklus)',
                    'Peralihan daya darurat tanpa gangguan peralatan sensitif',
                ],
                'diagram_image' => 'solutions/plts-on-grid-hybrid.webp',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'PLTS Off-Grid',
                'slug' => 'plts-off-grid',
                'system_type' => 'Off-Grid',
                'summary' => 'Sistem surya mandiri independen 100% tanpa ketergantungan pada jaringan transmisi PLN.',
                'system_architecture' => 'Seluruh kebutuhan energi listrik dipenuhi dari panel surya dan disimpan di dalam baterai berkapasitas besar. Sangat ideal untuk pulau terluar, pos perbatasan, basecamp pertambangan, dan desa terpencil. TODO-CONTENT: Diagram arsitektur.',
                'included_components' => [
                    'Panel Surya PV Standar Industri',
                    'Solar Charge Controller MPPT Efisiensi 99%',
                    'Off-Grid Pure Sine Wave Inverter',
                    'Bank Baterai LiFePO4 Kapasitas Besar (Otonomi 2-3 Hari)',
                    'Panel Proteksi Petir dan Arus Lebih',
                ],
                'benefits' => [
                    'Kemandirian energi total tanpa biaya bulanan transmisi',
                    'Solusi elektrifikasi daerah 3T (Tertinggal, Terdepan, Terluar)',
                    'Ramah lingkungan tanpa polusi suara dan emisi gas buang genset',
                    'Dirancang tangguh untuk kondisi iklim tropis Indonesia',
                ],
                'diagram_image' => 'solutions/plts-off-grid.webp',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'PLTS Off-Grid Hybrid',
                'slug' => 'plts-off-grid-hybrid',
                'system_type' => 'Hybrid',
                'summary' => 'Sistem mandiri terisolasi yang mengombinasikan energi surya dengan generator diesel (genset) untuk kebutuhan beban tinggi stabil.',
                'system_architecture' => 'Energi surya bertindak sebagai sumber utama pada siang hari. Controller cerdas mengatur genset agar hanya beroperasi saat baterai mencapai ambang batas minimum, menghemat konsumsi BBM diesel secara drastis. TODO-CONTENT: Diagram arsitektur.',
                'included_components' => [
                    'Array Panel Surya Fotovoltaik',
                    'Off-Grid Hybrid Inverter / Charger',
                    'Generator Diesel Interface & Auto Start Module',
                    'Bank Baterai Industri LiFePO4',
                    'Sistem Monitoring Bahan Bakar & Energi',
                ],
                'benefits' => [
                    'Menghemat konsumsi bahan bakar solar/diesel hingga 60-80%',
                    'Menjaga ketersediaan listrik 24/7 untuk operasional industri terpencil',
                    'Memperpanjang usia pakai mesin genset',
                    'Otomasi peralihan genset dan surya tanpa campur tangan operator',
                ],
                'diagram_image' => 'solutions/plts-off-grid-hybrid.webp',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Backup Power / UPS',
                'slug' => 'backup-power-ups',
                'system_type' => 'UPS',
                'summary' => 'Sistem catu daya darurat bertenaga surya dan baterai dengan waktu respon instan untuk beban kritis.',
                'system_architecture' => 'Dirancang untuk memproteksi peralatan sensitif (server data, peralatan medis, sistem telekomunikasi) dari lonjakan voltase, brownout, atau pemadaman listrik mendadak dengan transfer time 0 ms. TODO-CONTENT: Diagram arsitektur.',
                'included_components' => [
                    'Dedicated True Online Double Conversion Inverter',
                    'Baterai LiFePO4 High-Rate Discharge',
                    'Fast Static Transfer Switch (STS 0 ms)',
                    'Isolasi Transformator & Filter Harmonik',
                ],
                'benefits' => [
                    'Waktu peralihan tanpa jeda (0 ms) tanpa merestart server/komputer',
                    'Menghilangkan risiko kerusakan data dan alat industri akibat fluktuasi listrik',
                    'Pengisian ulang baterai dapat dikombinasikan dengan modul surya',
                    'Operasi hening dan bebas polusi di dalam ruangan server',
                ],
                'diagram_image' => 'solutions/backup-power-ups.webp',
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($solutions as $solution) {
            Solution::updateOrCreate(
                ['slug' => $solution['slug']],
                $solution
            );
        }
    }
}
