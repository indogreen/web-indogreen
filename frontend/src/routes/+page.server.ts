import type { PageServerLoad } from './$types.js';
import { api, DEFAULT_SITE_SETTINGS } from '$lib/server/api.js';
import type { HomeData } from '$lib/types/index.js';

export const load: PageServerLoad = async ({ fetch }) => {
  try {
    const homeData = await api.getHome(fetch);
    return {
      homeData,
      isApiAvailable: true
    };
  } catch {
    // Graceful fallback when backend API is unreachable
    const fallbackHomeData: HomeData = {
      hero_slides: [
        {
          id: 1,
          title: 'Lampu PJU Tenaga Surya Berkualitas Tinggi',
          subtitle:
            'Efisiensi maksimal dengan baterai LiFePO4 terintegrasi dan modul fotovoltaik Tier-1 bergaransi resmi.',
          button_text: 'Lihat Katalog Produk',
          button_url: '/produk',
          desktop_image: {
            original: '/images/hero-placeholder.svg',
            thumb: '/images/hero-placeholder.svg',
            card: '/images/hero-placeholder.svg',
            hero: '/images/hero-placeholder.svg',
            alt: 'Lampu PJU Tenaga Surya Berkualitas Tinggi INDOGREEN'
          },
          mobile_image: {
            original: '/images/hero-mobile-placeholder.svg',
            thumb: '/images/hero-mobile-placeholder.svg',
            card: '/images/hero-mobile-placeholder.svg',
            hero: '/images/hero-mobile-placeholder.svg',
            alt: 'Lampu PJU Tenaga Surya Berkualitas Tinggi INDOGREEN'
          },
          sort_order: 1
        }
      ],
      featured_products: [],
      solutions: [
        {
          id: 1,
          name: 'PLTS On-Grid System',
          slug: 'plts-on-grid',
          system_type: 'On-Grid',
          summary:
            'Sistem PLTS tersambung jaringan PLN untuk memangkas tagihan listrik harian melalui skema net-metering.',
          diagram_image: null,
          sort_order: 1
        },
        {
          id: 2,
          name: 'PLTS On-Grid Hybrid',
          slug: 'plts-on-grid-hybrid',
          system_type: 'Hybrid',
          summary:
            'Sistem hemat biaya tersambung PLN dengan proteksi baterai darurat saat terjadi pemadaman listrik.',
          diagram_image: null,
          sort_order: 2
        },
        {
          id: 3,
          name: 'PLTS Off-Grid Mandiri',
          slug: 'plts-off-grid',
          system_type: 'Off-Grid',
          summary:
            'Sistem mandiri 100% tanpa jaringan PLN, menggunakan bank baterai LiFePO4 untuk daerah terpencil.',
          diagram_image: null,
          sort_order: 3
        }
      ],
      categories: [
        {
          id: 1,
          name: 'PJU Tenaga Surya',
          slug: 'pju-tenaga-surya',
          description:
            'Lampu jalan mandiri sistem Two-In-One (TIO) dan All-In-One (AIO) untuk jalan protokol dan pedesaan.',
          icon_name: 'sun',
          sort_order: 1,
          products_count: 4,
          image: null
        },
        {
          id: 2,
          name: 'PLTS Residensial',
          slug: 'plts-residential',
          description:
            'Pembangkit listrik tenaga surya atap hemat daya untuk hunian mandiri dan efisiensi tagihan PLN.',
          icon_name: 'home',
          sort_order: 2,
          products_count: 0,
          image: null
        },
        {
          id: 3,
          name: 'Solar Home System',
          slug: 'solar-home-system',
          description:
            'Paket elektrifikasi surya DC/AC terpadu untuk wilayah 3T dan daerah tanpa akses jaringan listrik.',
          icon_name: 'battery-charging',
          sort_order: 3,
          products_count: 0,
          image: null
        },
        {
          id: 4,
          name: 'Aksesoris Kelistrikan',
          slug: 'aksesoris-kelistrikan',
          description:
            'Inverter gelombang sinus murni, baterai LiFePO4, kontroler MPPT cerdas, dan mounting bracket PV.',
          icon_name: 'cpu',
          sort_order: 4,
          products_count: 0,
          image: null
        }
      ],
      company: DEFAULT_SITE_SETTINGS
    };

    return {
      homeData: fallbackHomeData,
      isApiAvailable: false
    };
  }
};
