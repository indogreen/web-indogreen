import { error } from '@sveltejs/kit';
import type { PageServerLoad } from './$types.js';
import { api, ApiClientError } from '$lib/server/api.js';
import type { SolutionDetail } from '$lib/types/index.js';

export const load: PageServerLoad = async ({ params, fetch }) => {
  const { slug } = params;

  try {
    const solution = await api.getSolution(slug, fetch);
    return {
      solution
    };
  } catch (err) {
    if (err instanceof ApiClientError && err.status === 404) {
      error(404, `Solusi sistem '${slug}' tidak ditemukan.`);
    }

    // Fallback mock if backend API is not accessible in local environment
    const knownSolutions: Record<string, SolutionDetail> = {
      'plts-on-grid': {
        id: 1,
        name: 'PLTS On-Grid System',
        slug: 'plts-on-grid',
        system_type: 'On-Grid',
        summary:
          'Sistem PLTS tersambung jaringan PLN untuk memangkas tagihan listrik harian melalui skema net-metering tanpa baterai.',
        system_architecture:
          '<p>Pada sistem PLTS On-Grid, modul fotovoltaik surya (Solar PV) menyerap sinar matahari dan menghasilkan arus searah (DC). Arus ini dialirkan ke inverter grid-tie yang secara sinkron mengubah arus DC menjadi arus bolak-balik (AC 220V/380V) dengan fase dan frekuensi yang identik dengan jaringan PLN.</p><p>Energi listrik yang dihasilkan langsung dikonsumsi oleh peralatan listrik di gedung. Apabila daya surya melebihi kebutuhan saat siang hari, surplus daya dialirkan kembali ke jaringan PLN melalui meteran dua arah (kWh meter Exim), sehingga memangkas tagihan listrik bulanan secara efektif.</p>',
        included_components: [
          'Modul Panel Surya Monocrystalline Tier-1 High Efficiency',
          'Inverter Grid-Tie Bersertifikasi dengan Efisiensi > 98%',
          'Sistem Proteksi AC/DC Combiner Box & SPD (Surge Protection Device)',
          'Sistem Pembumian (Grounding) Tembaga Murni < 2 Ohm',
          'Struktur Dudukan Bracket Aluminium Alloy 6005-T5 Anti-Korosi',
          'kWh Meter Ekspor-Impor (Net-Metering) Standar PLN'
        ],
        benefits: [
          'Memangkas 40% hingga 80% biaya tagihan listrik harian operasional',
          'Biaya investasi per Watt-peak paling ekonomis karena tanpa bank baterai',
          'Minim perawatan operasional dengan masa pakai modul hingga 25 tahun',
          'Otomatis menyuplai daya bersama jaringan PLN tanpa jeda kedip listrik',
          'Mendukung pencapaian target emisi nol bersih (Net Zero Emission / ESG)'
        ],
        diagram_image: null,
        products: [],
        seo_title: 'Solusi PLTS On-Grid Sistem Hemat Listrik',
        seo_description:
          'Pembangkit listrik tenaga surya atap sistem On-Grid tersambung PLN untuk efisiensi tagihan listrik hunian dan industri PT. Indogreen.',
        sort_order: 1
      },
      'plts-on-grid-hybrid': {
        id: 2,
        name: 'PLTS On-Grid Hybrid System',
        slug: 'plts-on-grid-hybrid',
        system_type: 'Hybrid',
        summary:
          'Sistem hemat biaya tersambung PLN dengan integrasi bank baterai LiFePO4 untuk cadangan daya darurat saat pemadaman.',
        system_architecture:
          '<p>Sistem PLTS On-Grid Hybrid menggabungkan keuntungan efisiensi penghematan biaya dari sistem on-grid dengan keandalan suplai daya darurat (UPS) melalui baterai penyimpanan berkapasitas tinggi.</p><p>Saat jaringan PLN aktif, sistem mengoptimalkan konsumsi surya dan mengecas baterai. Apabila jaringan PLN padam, sistem secara otomatis beralih ke mode off-grid dalam waktu kurang dari 10 milidetik, menjaga beban kritis tetap menyala normal.</p>',
        included_components: [
          'Modul Fotovoltaik Tier-1 Efisiensi Tinggi',
          'Inverter Hybrid Cerdas dengan Mode Zero-Export & Backup',
          'Bank Baterai Lithium Iron Phosphate (LiFePO4) Kapasitas Tinggi',
          'Automatic Transfer Switch (ATS) Kecepatan Tinggi (< 10 ms)',
          'Smart Energy Meter & Sistem Monitoring WiFi/Cloud'
        ],
        benefits: [
          'Keandalan ganda: penghematan tagihan listrik sekaligus cadangan daya tanpa padam',
          'Perlindungan instan untuk perangkat elektronik sensitif terhadap lonjakan daya',
          'Pengisian baterai otomatis dari surya dan jaringan PLN di luar jam puncak',
          'Dukungan siklus hidup baterai LiFePO4 lebih dari 4.000 siklus'
        ],
        diagram_image: null,
        products: [],
        seo_title: 'Solusi PLTS On-Grid Hybrid Anti Pemadaman',
        seo_description:
          'Sistem PLTS On-Grid Hybrid dengan cadangan baterai LiFePO4 cerdas untuk kontinuitas daya tanpa jeda PT. Indogreen.',
        sort_order: 2
      },
      'plts-off-grid': {
        id: 3,
        name: 'PLTS Off-Grid Mandiri',
        slug: 'plts-off-grid',
        system_type: 'Off-Grid',
        summary:
          'Sistem mandiri 100% tanpa jaringan transmisi PLN, menggunakan bank baterai LiFePO4 untuk elektrifikasi pulau dan daerah 3T.',
        system_architecture:
          '<p>PLTS Off-Grid dirancang untuk beroperasi secara mandiri tanpa memerlukan koneksi ke jaringan utilitas PLN. Sistem ini cocok untuk wilayah kepulauan, perkebunan terpencil, pos pemantauan perbatasan, menara telekomunikasi (BTS), dan desa pedalaman.</p><p>Energi surya disimpan sepenuhnya di dalam baterai kimia LiFePO4 melalui kontroler MPPT presisi, lalu diubah menjadi tegangan AC untuk melayani kebutuhan 24 jam sehari.</p>',
        included_components: [
          'Array Modul Surya Monocrystalline Kapasitas Sesuai Kebutuhan',
          'Solar Charge Controller (MPPT) Efisiensi Pelacakan 99.5%',
          'Inverter Off-Grid Gelombang Sinus Murni (Pure Sine Wave)',
          'Bank Baterai LiFePO4 Rakitan Modular dengan BMS Cerdas',
          'Panel Distribusi AC/DC dengan Proteksi Lengkap'
        ],
        benefits: [
          'Kemandirian energi mutlak 100% tanpa ketergantungan jaringan listrik luar',
          'Solusi ideal untuk elektrifikasi pulau terluar, daerah 3T, dan perkebunan',
          'Menghilangkan biaya bahan bakar solar genset yang mahal dan berpolusi',
          'Sistem modular yang dapat diekspansi kapasitasnya seiring pertumbuhan beban'
        ],
        diagram_image: null,
        products: [],
        seo_title: 'Solusi PLTS Off-Grid Mandiri Tanpa Jaringan PLN',
        seo_description:
          'Pembangkit listrik tenaga surya mandiri 100% off-grid dengan baterai LiFePO4 untuk daerah terpencil dan pulau terluar.',
        sort_order: 3
      }
    };

    if (knownSolutions[slug]) {
      return {
        solution: knownSolutions[slug]
      };
    }

    error(404, `Solusi sistem '${slug}' tidak ditemukan.`);
  }
};
