import { describe, it, expect, vi, beforeEach } from 'vitest';
import { api, ApiClientError, DEFAULT_SITE_SETTINGS } from '$lib/server/api.js';
import { load as loadHome } from './+page.server.js';
import { load as loadProducts } from './produk/+page.server.js';
import { load as loadCategory } from './produk/[category]/+page.server.js';
import { load as loadProductDetail } from './produk/[category]/[slug]/+page.server.js';
import { load as loadSolutions } from './solusi/+page.server.js';
import { load as loadSolutionDetail } from './solusi/[slug]/+page.server.js';
import type {
  HomeData,
  ProductCategory,
  ProductListItem,
  ProductDetail,
  SolutionListItem,
  SolutionDetail,
  ApiMeta
} from '$lib/types/index.js';

type HomeLoadEvent = Parameters<typeof loadHome>[0];
type ProductsLoadEvent = Parameters<typeof loadProducts>[0];
type CategoryLoadEvent = Parameters<typeof loadCategory>[0];
type ProductDetailLoadEvent = Parameters<typeof loadProductDetail>[0];
type SolutionsLoadEvent = Parameters<typeof loadSolutions>[0];
type SolutionDetailLoadEvent = Parameters<typeof loadSolutionDetail>[0];

interface HomeLoadResult {
  homeData: HomeData;
  isApiAvailable: boolean;
}

interface ProductsLoadResult {
  categories: ProductCategory[];
  products: ProductListItem[];
  meta: ApiMeta | null;
  selectedCategory: string;
  currentPage: number;
}

interface CategoryLoadResult {
  category: ProductCategory;
  products: ProductListItem[];
  categories: ProductCategory[];
}

interface ProductDetailLoadResult {
  product: ProductDetail;
  relatedProducts: ProductListItem[];
}

interface SolutionsLoadResult {
  solutions: SolutionListItem[];
}

interface SolutionDetailLoadResult {
  solution: SolutionDetail;
}

function createMockEvent(params: Record<string, string> = {}, urlStr = 'http://localhost:3000/') {
  return {
    params,
    url: new URL(urlStr),
    fetch: vi.fn(),
    cookies: {},
    request: {},
    route: { id: '/' },
    setHeaders: vi.fn(),
    parent: vi.fn().mockResolvedValue({}),
    depends: vi.fn(),
    untrack: vi.fn(),
    isDataRequest: false
  };
}

describe('Route Server Load Functions (Phase 7)', () => {
  beforeEach(() => {
    vi.restoreAllMocks();
  });

  describe('Home Page Loader (+page.server.ts)', () => {
    it('returns home data from API when successful', async () => {
      const mockHomeData: HomeData = {
        hero_slides: [
          {
            id: 1,
            title: 'Lampu PJU Tenaga Surya Berkualitas Tinggi',
            subtitle: 'Baterai LiFePO4 terintegrasi',
            button_text: 'Lihat Produk',
            button_url: '/produk',
            desktop_image: null,
            mobile_image: null,
            sort_order: 1
          }
        ],
        featured_products: [],
        solutions: [],
        categories: [],
        company: DEFAULT_SITE_SETTINGS
      };

      vi.spyOn(api, 'getHome').mockResolvedValueOnce(mockHomeData);

      const event = createMockEvent() as unknown as HomeLoadEvent;
      const result = (await loadHome(event)) as HomeLoadResult;

      expect(result.homeData.hero_slides[0].title).toBe(
        'Lampu PJU Tenaga Surya Berkualitas Tinggi'
      );
      expect(result.isApiAvailable).toBe(true);
    });

    it('gracefully falls back when API fails without crashing', async () => {
      vi.spyOn(api, 'getHome').mockRejectedValueOnce(new ApiClientError('Connection failed', 503));

      const event = createMockEvent() as unknown as HomeLoadEvent;
      const result = (await loadHome(event)) as HomeLoadResult;

      expect(result.homeData).toBeDefined();
      expect(result.homeData.hero_slides.length).toBeGreaterThan(0);
      expect(result.isApiAvailable).toBe(false);
    });
  });

  describe('Products Catalog Loader (produk/+page.server.ts)', () => {
    it('loads products and categories without filter', async () => {
      const mockCats: ProductCategory[] = [
        {
          id: 1,
          name: 'PJU Tenaga Surya',
          slug: 'pju-tenaga-surya',
          sort_order: 1
        }
      ];

      const mockProducts: ProductListItem[] = [
        {
          id: 1,
          name: 'Helios 60W',
          slug: 'helios-60w',
          category_slug: 'pju-tenaga-surya',
          category_name: 'PJU Tenaga Surya',
          is_featured: true,
          sort_order: 1
        }
      ];

      vi.spyOn(api, 'getCategories').mockResolvedValueOnce(mockCats);
      vi.spyOn(api, 'getProducts').mockResolvedValueOnce({
        data: mockProducts,
        meta: { current_page: 1, last_page: 1, per_page: 12, total: 1 }
      });

      const event = createMockEvent(
        {},
        'http://localhost:3000/produk'
      ) as unknown as ProductsLoadEvent;
      const result = (await loadProducts(event)) as ProductsLoadResult;

      expect(result.categories.length).toBe(1);
      expect(result.products.length).toBe(1);
      expect(result.selectedCategory).toBe('');
      expect(result.currentPage).toBe(1);
    });

    it('applies category filter from URL search params (?kategori=)', async () => {
      const getProductsSpy = vi.spyOn(api, 'getProducts').mockResolvedValueOnce({
        data: [],
        meta: { current_page: 1, last_page: 1, per_page: 12, total: 0 }
      });

      const event = createMockEvent(
        {},
        'http://localhost:3000/produk?kategori=pju-tenaga-surya&page=2'
      ) as unknown as ProductsLoadEvent;
      const result = (await loadProducts(event)) as ProductsLoadResult;

      expect(result.selectedCategory).toBe('pju-tenaga-surya');
      expect(result.currentPage).toBe(2);
      expect(getProductsSpy).toHaveBeenCalledWith(
        expect.objectContaining({
          category: 'pju-tenaga-surya',
          page: 2
        }),
        expect.any(Function)
      );
    });
  });

  describe('Category Page Loader (produk/[category]/+page.server.ts)', () => {
    it('loads category and products for existing category slug', async () => {
      const mockCategory: ProductCategory = {
        id: 1,
        name: 'PJU Tenaga Surya',
        slug: 'pju-tenaga-surya',
        description: 'Lampu jalan mandiri',
        sort_order: 1
      };

      const mockProducts: ProductListItem[] = [
        {
          id: 1,
          name: 'Helios 60W',
          slug: 'helios-60w',
          category_slug: 'pju-tenaga-surya',
          category_name: 'PJU Tenaga Surya',
          is_featured: true,
          sort_order: 1
        }
      ];

      vi.spyOn(api, 'getCategory').mockResolvedValueOnce({
        category: mockCategory,
        products: mockProducts
      });

      const event = createMockEvent({
        category: 'pju-tenaga-surya'
      }) as unknown as CategoryLoadEvent;
      const result = (await loadCategory(event)) as CategoryLoadResult;

      expect(result.category.name).toBe('PJU Tenaga Surya');
      expect(result.products.length).toBe(1);
    });

    it('throws 404 when category does not exist', async () => {
      vi.spyOn(api, 'getCategory').mockRejectedValueOnce(new ApiClientError('Not Found', 404));

      const event = createMockEvent({
        category: 'kategori-fiktif-999'
      }) as unknown as CategoryLoadEvent;
      await expect(loadCategory(event)).rejects.toThrow();
    });
  });

  describe('Product Detail Loader (produk/[category]/[slug]/+page.server.ts)', () => {
    it('loads product details and related products for valid slugs', async () => {
      const mockProduct: ProductDetail = {
        id: 1,
        name: 'PJU Two-In-One Helios Series',
        slug: 'pju-two-in-one-helios-series',
        category_slug: 'pju-tenaga-surya',
        category_name: 'PJU Tenaga Surya',
        category: { id: 1, name: 'PJU Tenaga Surya', slug: 'pju-tenaga-surya' },
        short_description: 'Lampu jalan surya',
        is_featured: true,
        sort_order: 1
      };

      const mockOtherProduct: ProductListItem = {
        id: 2,
        name: 'PJU Jupiter Series',
        slug: 'pju-jupiter',
        category_slug: 'pju-tenaga-surya',
        category_name: 'PJU Tenaga Surya',
        is_featured: false,
        sort_order: 2
      };

      vi.spyOn(api, 'getProduct').mockResolvedValueOnce(mockProduct);
      vi.spyOn(api, 'getCategory').mockResolvedValueOnce({
        category: { ...mockProduct.category, sort_order: 1 },
        products: [mockProduct, mockOtherProduct]
      });

      const event = createMockEvent({
        category: 'pju-tenaga-surya',
        slug: 'pju-two-in-one-helios-series'
      }) as unknown as ProductDetailLoadEvent;

      const result = (await loadProductDetail(event)) as ProductDetailLoadResult;
      expect(result.product.name).toBe('PJU Two-In-One Helios Series');
      expect(result.relatedProducts.length).toBe(1);
      expect(result.relatedProducts[0].slug).toBe('pju-jupiter');
    });

    it('throws 404 when product slug is invalid', async () => {
      vi.spyOn(api, 'getProduct').mockRejectedValueOnce(
        new ApiClientError('Product Not Found', 404)
      );

      const event = createMockEvent({
        category: 'pju-tenaga-surya',
        slug: 'produk-tidak-ditemukan-404'
      }) as unknown as ProductDetailLoadEvent;

      await expect(loadProductDetail(event)).rejects.toThrow();
    });
  });

  describe('Solutions Loaders (solusi/+page.server.ts & [slug]/+page.server.ts)', () => {
    it('loads solutions catalog successfully', async () => {
      const mockSolutions: SolutionListItem[] = [
        {
          id: 1,
          name: 'PLTS On-Grid System',
          slug: 'plts-on-grid',
          system_type: 'On-Grid',
          summary: 'Sistem atap surya on-grid',
          sort_order: 1
        }
      ];

      vi.spyOn(api, 'getSolutions').mockResolvedValueOnce(mockSolutions);

      const event = createMockEvent() as unknown as SolutionsLoadEvent;
      const result = (await loadSolutions(event)) as SolutionsLoadResult;
      expect(result.solutions.length).toBe(1);
      expect(result.solutions[0].slug).toBe('plts-on-grid');
    });

    it('loads single solution detail by slug', async () => {
      const mockSolutionDetail: SolutionDetail = {
        id: 1,
        name: 'PLTS On-Grid System',
        slug: 'plts-on-grid',
        system_type: 'On-Grid',
        summary: 'Sistem atap surya on-grid',
        included_components: ['Modul Surya Monocrystalline'],
        benefits: ['Hemat listrik hingga 60%'],
        sort_order: 1
      };

      vi.spyOn(api, 'getSolution').mockResolvedValueOnce(mockSolutionDetail);

      const event = createMockEvent({
        slug: 'plts-on-grid'
      }) as unknown as SolutionDetailLoadEvent;
      const result = (await loadSolutionDetail(event)) as SolutionDetailLoadResult;
      expect(result.solution.name).toBe('PLTS On-Grid System');
      expect(result.solution.benefits?.length).toBe(1);
    });

    it('throws 404 when solution slug does not exist', async () => {
      vi.spyOn(api, 'getSolution').mockRejectedValueOnce(
        new ApiClientError('Solution Not Found', 404)
      );

      const event = createMockEvent({
        slug: 'solusi-fiktif-404'
      }) as unknown as SolutionDetailLoadEvent;
      await expect(loadSolutionDetail(event)).rejects.toThrow();
    });
  });
});
