import { error } from '@sveltejs/kit';
import type { PageServerLoad } from './$types.js';
import { api, ApiClientError } from '$lib/server/api.js';
import type { ProductCategory } from '$lib/types/index.js';

export const load: PageServerLoad = async ({ params, fetch }) => {
  const categorySlug = params.category;

  try {
    const [categoryData, categoriesRes] = await Promise.all([
      api.getCategory(categorySlug, fetch),
      api.getCategories(fetch).catch(() => [] as ProductCategory[])
    ]);

    return {
      category: categoryData.category,
      products: categoryData.products,
      categories: categoriesRes
    };
  } catch (err) {
    if (err instanceof ApiClientError && err.status === 404) {
      error(404, `Kategori produk '${categorySlug}' tidak ditemukan.`);
    }

    // Fallback if local backend is down: check against known category slugs
    const knownCategories: Record<string, { name: string; description: string }> = {
      'pju-tenaga-surya': {
        name: 'PJU Tenaga Surya',
        description:
          'Lampu penerangan jalan umum mandiri bertenaga surya sistem Two-In-One dan All-In-One.'
      },
      'plts-residential': {
        name: 'PLTS Residensial',
        description: 'Paket atap surya hemat daya mandiri untuk hunian dan efisiensi tagihan PLN.'
      },
      'solar-home-system': {
        name: 'Solar Home System',
        description: 'Paket elektrifikasi surya DC/AC terpadu untuk wilayah 3T dan pedesaan.'
      },
      'aksesoris-kelistrikan': {
        name: 'Aksesoris Kelistrikan',
        description: 'Inverter, Baterai LiFePO4, Solar Charge Controller MPPT, Mounting Bracket PV.'
      }
    };

    if (knownCategories[categorySlug]) {
      return {
        category: {
          id: 1,
          name: knownCategories[categorySlug].name,
          slug: categorySlug,
          description: knownCategories[categorySlug].description,
          icon_name: 'sun',
          sort_order: 1,
          products_count: 0,
          image: null
        },
        products: [],
        categories: Object.entries(knownCategories).map(([slug, cat], idx) => ({
          id: idx + 1,
          name: cat.name,
          slug,
          description: cat.description,
          icon_name: 'sun',
          sort_order: idx + 1,
          products_count: 0,
          image: null
        }))
      };
    }

    error(404, `Kategori produk '${categorySlug}' tidak ditemukan.`);
  }
};
