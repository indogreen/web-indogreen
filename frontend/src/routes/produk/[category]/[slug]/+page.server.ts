import { error } from '@sveltejs/kit';
import type { PageServerLoad } from './$types.js';
import { api, ApiClientError } from '$lib/server/api.js';
import type { ProductDetail, ProductListItem } from '$lib/types/index.js';

export const load: PageServerLoad = async ({ params, fetch }) => {
  const { category: categorySlug, slug: productSlug } = params;

  try {
    const product = await api.getProduct(categorySlug, productSlug, fetch);

    // Fetch related products in the same category
    let relatedProducts: ProductListItem[] = [];
    try {
      const categoryRes = await api.getCategory(categorySlug, fetch);
      relatedProducts = categoryRes.products
        .filter((p) => p.slug !== productSlug && p.id !== product.id)
        .slice(0, 4);
    } catch {
      relatedProducts = [];
    }

    return {
      product,
      relatedProducts
    };
  } catch (err) {
    if (err instanceof ApiClientError && err.status === 404) {
      error(404, `Produk '${productSlug}' tidak ditemukan dalam kategori '${categorySlug}'.`);
    }

    // Fallback mock if backend is down for development testing
    if (productSlug.includes('helios') || productSlug.includes('sample')) {
      const fallbackProduct: ProductDetail = {
        id: 1,
        name: 'PJU Two-In-One Helios Series',
        slug: productSlug,
        category_slug: categorySlug,
        category_name: 'PJU Tenaga Surya',
        category: {
          id: 1,
          name: 'PJU Tenaga Surya',
          slug: categorySlug
        },
        model_series: 'Helios',
        badge_tag: 'Best Seller',
        short_description:
          'Lampu Penerangan Jalan Umum mandiri tenaga surya hemat daya dengan baterai LiFePO4 dan controller cerdas MPPT terintegrasi.',
        full_description:
          '<p>PJU Two-In-One Helios Series menggabungkan lampu LED efisiensi tinggi, sensor peredupan otomatis, dan sistem baterai lithium besi fosfat (LiFePO4) dengan modul solar panel terpisah yang dapat diatur sudut kemiringannya secara presisi untuk menangkap radiasi matahari maksimal di wilayah Indonesia.</p><p>Sangat ideal untuk jalan arteri, jalan protokol perkotaan, kawasan industri, dan area perumahan modern yang mengutamakan efisiensi dan kemandirian energi.</p>',
        featured_image: {
          original: '/images/product-pju-placeholder.svg',
          thumb: '/images/product-pju-placeholder.svg',
          card: '/images/product-pju-placeholder.svg',
          hero: '/images/product-pju-placeholder.svg',
          alt: 'PJU Two-In-One Helios Series INDOGREEN'
        },
        gallery: [
          {
            original: '/images/product-pju-placeholder.svg',
            thumb: '/images/product-pju-placeholder.svg',
            card: '/images/product-pju-placeholder.svg',
            hero: '/images/product-pju-placeholder.svg',
            alt: 'PJU Two-In-One Helios Series - Sudut Depan'
          }
        ],
        datasheet_pdf_url: '/dummy-assets/datasheet-sample.md',
        specifications_grouped: {
          'Lampu & Optik': [
            { key: 'Daya Lampu (Wattage)', value: '60', unit: 'W' },
            { key: 'Fluks Cahaya (Luminous Flux)', value: '9.600 - 10.200', unit: 'Lumen' },
            { key: 'Temperatur Warna (CCT)', value: '5000 - 6500', unit: 'K' },
            { key: 'Sudut Pencahayaan', value: '140 × 70', unit: 'Derajat' }
          ],
          'Panel Surya & Baterai': [
            { key: 'Modul Panel Surya (PV)', value: '100', unit: 'Wp Monocrystalline Tier-1' },
            { key: 'Tipe Baterai', value: 'Lithium Iron Phosphate (LiFePO4)', unit: null },
            { key: 'Kapasitas Baterai', value: '42', unit: 'Ah (12.8V)' },
            { key: 'Siklus Hidup Baterai', value: '> 2.000', unit: 'Siklus (@80% DoD)' }
          ],
          'Sistem Kontrol & Proteksi': [
            {
              key: 'Kontroler Pengisian',
              value: 'Cerdas MPPT dengan Sensor Cahaya & Waktu',
              unit: null
            },
            { key: 'Waktu Pengisian (Charging)', value: '5 - 6', unit: 'Jam (Terik Matahari)' },
            { key: 'Durasi Nyala Otonom', value: '2 - 3', unit: 'Hari Hujan / Mendung' },
            { key: 'Ketahanan Cuaca (Ingress Protection)', value: 'IP66', unit: null },
            { key: 'Rekomendasi Ketinggian Tiang', value: '6 - 8', unit: 'Meter' }
          ]
        },
        solutions: [
          {
            id: 1,
            name: 'Penerangan Jalan Umum Mandiri',
            slug: 'plts-off-grid',
            system_type: 'PJU TIO'
          }
        ],
        seo_title: 'Jual Lampu PJU Two-In-One Helios Series 60W',
        seo_description:
          'Spesifikasi teknis resmi lampu jalan PJU tenaga surya Two-In-One Helios Series 60W dengan baterai LiFePO4 garansi resmi PT. Indogreen.',
        is_featured: true,
        sort_order: 1
      };

      return {
        product: fallbackProduct,
        relatedProducts: []
      };
    }

    error(404, `Produk '${productSlug}' tidak ditemukan dalam kategori '${categorySlug}'.`);
  }
};
