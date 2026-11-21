import type { PageServerLoad } from './$types.js';
import { api } from '$lib/server/api.js';
import type { ProductCategory } from '$lib/types/index.js';

const fallbackCategories: ProductCategory[] = [
  {
    id: 1,
    name: 'PJU Tenaga Surya',
    slug: 'pju-tenaga-surya',
    description: 'Lampu jalan surya mandiri sistem Two-In-One dan All-In-One.',
    icon_name: 'sun',
    sort_order: 1,
    products_count: 4,
    image: null
  },
  {
    id: 2,
    name: 'PLTS Residensial',
    slug: 'plts-residential',
    description: 'Paket atap surya hemat daya mandiri untuk perumahan.',
    icon_name: 'home',
    sort_order: 2,
    products_count: 0,
    image: null
  },
  {
    id: 3,
    name: 'Solar Home System',
    slug: 'solar-home-system',
    description: 'Paket elektrifikasi surya pedesaan dan daerah terpencil / 3T.',
    icon_name: 'battery-charging',
    sort_order: 3,
    products_count: 0,
    image: null
  },
  {
    id: 4,
    name: 'Aksesoris Kelistrikan',
    slug: 'aksesoris-kelistrikan',
    description: 'Inverter, Baterai LiFePO4, Solar Charge Controller MPPT, Mounting Bracket.',
    icon_name: 'cpu',
    sort_order: 4,
    products_count: 0,
    image: null
  }
];

export const load: PageServerLoad = async ({ url, fetch }) => {
  const selectedCategory = url.searchParams.get('kategori') || '';
  const currentPage = Math.max(1, parseInt(url.searchParams.get('page') || '1', 10) || 1);

  try {
    const [categoriesRes, productsRes] = await Promise.all([
      api.getCategories(fetch).catch(() => [] as ProductCategory[]),
      api
        .getProducts(
          {
            category: selectedCategory || undefined,
            page: currentPage,
            per_page: 12
          },
          fetch
        )
        .catch(() => ({ data: [], meta: null }))
    ]);

    const categories = categoriesRes.length > 0 ? categoriesRes : fallbackCategories;

    return {
      categories,
      products: productsRes.data,
      meta: productsRes.meta ?? null,
      selectedCategory,
      currentPage
    };
  } catch {
    return {
      categories: fallbackCategories,
      products: [],
      meta: null,
      selectedCategory,
      currentPage
    };
  }
};
