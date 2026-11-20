import { env } from '$env/dynamic/private';
import type {
  ApiResponse,
  ApiErrorResponse,
  SiteSettings,
  HomeData,
  ProductCategory,
  ProductListItem,
  ProductDetail,
  SolutionListItem,
  SolutionDetail,
  CmsPage,
  SearchResults,
  InquiryPayload,
  InquiryResponse,
  ApiMeta
} from '../types/index.js';

export class ApiClientError extends Error {
  status: number;
  errorCode?: string;
  errors?: Record<string, string[]>;

  constructor(
    message: string,
    status: number,
    errorCode?: string,
    errors?: Record<string, string[]>
  ) {
    super(message);
    this.name = 'ApiClientError';
    this.status = status;
    this.errorCode = errorCode;
    this.errors = errors;
  }
}

export interface RequestOptions extends RequestInit {
  timeoutMs?: number;
  fetchFn?: typeof fetch;
  params?: Record<string, string | number | boolean | undefined>;
}

export function getApiBaseUrl(): string {
  try {
    return env?.API_BASE_URL || process.env.API_BASE_URL || 'http://localhost:8000/api/v1';
  } catch {
    return process.env.API_BASE_URL || 'http://localhost:8000/api/v1';
  }
}

/**
 * Default fallback company settings when the backend API is unreachable
 */
export const DEFAULT_SITE_SETTINGS: SiteSettings = {
  company_name: 'PT. INDOGREEN TECHNOLOGY AND MANAGEMENT',
  tagline: 'SOLAR ENERGY COMPANY / Konsentrasi kami adalah energy ramah lingkungan',
  phone: '+62 251 754 1234',
  email: 'marketing@indogreen.id',
  whatsapp: '+62 811 1234 5678',
  head_office_address: 'Ruko Taman Yasmin Sektor 6 No. 226, Kota Bogor, Jawa Barat 16113',
  representative_office_address:
    'Gedung Wisma Bumiputera Lt. 7, Jl. Asia Afrika No. 141-149, Kota Bandung',
  social_links: {
    facebook: 'https://facebook.com/indogreen.id',
    instagram: 'https://instagram.com/indogreen.id',
    youtube: 'https://youtube.com/@indogreentechnology',
    linkedin: 'https://linkedin.com/company/indogreen'
  },
  offices: [
    {
      id: 1,
      name: 'Kantor Utama Bogor',
      office_type: 'head_office',
      office_type_label: 'Kantor Utama',
      address: 'Ruko Taman Yasmin Sektor 6 No. 226, Kota Bogor, Jawa Barat 16113',
      phone: '+62 251 754 1234',
      email: 'bogor@indogreen.id',
      map_embed_url: null,
      sort_order: 1
    },
    {
      id: 2,
      name: 'Kantor Perwakilan Bandung',
      office_type: 'representative_office',
      office_type_label: 'Kantor Perwakilan',
      address: 'Gedung Wisma Bumiputera Lt. 7, Jl. Asia Afrika No. 141-149, Kota Bandung',
      phone: '+62 22 420 5678',
      email: 'bandung@indogreen.id',
      map_embed_url: null,
      sort_order: 2
    }
  ]
};

/**
 * Core HTTP client function for server-only communication with the Laravel REST API
 */
export async function apiRequest<T>(
  endpoint: string,
  options: RequestOptions = {}
): Promise<ApiResponse<T>> {
  const baseUrl = getApiBaseUrl().replace(/\/$/, '');
  const cleanEndpoint = endpoint.startsWith('/') ? endpoint : `/${endpoint}`;

  let urlString = `${baseUrl}${cleanEndpoint}`;
  if (options.params) {
    const searchParams = new URLSearchParams();
    for (const [key, value] of Object.entries(options.params)) {
      if (value !== undefined && value !== null && value !== '') {
        searchParams.append(key, String(value));
      }
    }
    const queryString = searchParams.toString();
    if (queryString) {
      urlString += (urlString.includes('?') ? '&' : '?') + queryString;
    }
  }

  const timeoutMs = options.timeoutMs ?? 8000;
  const activeFetch = options.fetchFn ?? fetch;

  const controller = new AbortController();
  const timeoutId = setTimeout(() => controller.abort(), timeoutMs);

  const headers = new Headers(options.headers);
  if (!headers.has('Accept')) {
    headers.set('Accept', 'application/json');
  }

  let body = options.body;
  if (body) {
    if (typeof body === 'object' && !(body instanceof FormData) && !(body instanceof Blob)) {
      body = JSON.stringify(body);
    }
    if (typeof body === 'string' && !headers.has('Content-Type')) {
      headers.set('Content-Type', 'application/json');
    }
  }

  try {
    const response = await activeFetch(urlString, {
      ...options,
      headers,
      body,
      signal: controller.signal
    });

    clearTimeout(timeoutId);

    const contentType = response.headers.get('content-type');
    const isJson = contentType && contentType.includes('application/json');

    if (!response.ok) {
      let errorData: Partial<ApiErrorResponse> = {};
      if (isJson) {
        try {
          errorData = (await response.json()) as Partial<ApiErrorResponse>;
        } catch {
          // ignore parsing error
        }
      }

      const message =
        errorData.message ||
        (response.status === 404
          ? 'Sumber daya tidak ditemukan.'
          : response.status === 422
            ? 'Data yang dikirimkan tidak valid.'
            : response.status === 429
              ? 'Terlalu banyak permintaan. Silakan tunggu beberapa saat.'
              : `Terjadi gangguan server (HTTP ${response.status}).`);

      throw new ApiClientError(message, response.status, errorData.error_code, errorData.errors);
    }

    if (isJson) {
      const parsedData: unknown = await response.json();
      return parsedData as ApiResponse<T>;
    }

    return {
      success: true,
      message: 'Operasi berhasil dieksekusi.',
      data: (await response.text()) as unknown as T
    };
  } catch (err: unknown) {
    clearTimeout(timeoutId);

    if (err instanceof ApiClientError) {
      throw err;
    }

    if (err instanceof Error) {
      if (err.name === 'AbortError') {
        throw new ApiClientError(
          'Permintaan ke server backend melebihi batas waktu (timeout).',
          504,
          'GATEWAY_TIMEOUT'
        );
      }
      throw new ApiClientError(
        `Koneksi ke backend gagal: ${err.message}`,
        503,
        'SERVICE_UNAVAILABLE'
      );
    }

    throw new ApiClientError(
      'Terjadi kesalahan tak terduga saat menghubungi server.',
      500,
      'INTERNAL_SERVER_ERROR'
    );
  }
}

/**
 * High-level typed API service methods
 */
export const api = {
  get: <T>(endpoint: string, options?: RequestOptions) =>
    apiRequest<T>(endpoint, { ...options, method: 'GET' }),

  post: <T>(endpoint: string, body?: unknown, options?: RequestOptions) =>
    apiRequest<T>(endpoint, {
      ...options,
      method: 'POST',
      body: body as BodyInit
    }),

  async getSettings(fetchFn?: typeof fetch): Promise<SiteSettings> {
    try {
      const res = await apiRequest<SiteSettings>('/settings', { fetchFn });
      return res.data;
    } catch {
      // Fallback gracefully to default settings if backend is down
      return DEFAULT_SITE_SETTINGS;
    }
  },

  async getHome(fetchFn?: typeof fetch): Promise<HomeData> {
    const res = await apiRequest<HomeData>('/home', { fetchFn });
    return res.data;
  },

  async getCategories(fetchFn?: typeof fetch): Promise<ProductCategory[]> {
    const res = await apiRequest<ProductCategory[]>('/product-categories', { fetchFn });
    return res.data;
  },

  async getCategory(
    slug: string,
    fetchFn?: typeof fetch
  ): Promise<{ category: ProductCategory; products: ProductListItem[] }> {
    const res = await apiRequest<{ category: ProductCategory; products: ProductListItem[] }>(
      `/product-categories/${slug}`,
      { fetchFn }
    );
    return res.data;
  },

  async getProducts(
    params?: {
      category?: string;
      search?: string;
      featured?: boolean;
      page?: number;
      per_page?: number;
    },
    fetchFn?: typeof fetch
  ): Promise<{ data: ProductListItem[]; meta?: ApiMeta | null }> {
    const res = await apiRequest<ProductListItem[]>('/products', {
      fetchFn,
      params: {
        category: params?.category,
        q: params?.search,
        featured: params?.featured ? 1 : undefined,
        page: params?.page,
        per_page: params?.per_page
      }
    });
    return { data: res.data, meta: res.meta };
  },

  async getProduct(
    categorySlug: string,
    productSlug: string,
    fetchFn?: typeof fetch
  ): Promise<ProductDetail> {
    const res = await apiRequest<ProductDetail>(`/products/${categorySlug}/${productSlug}`, {
      fetchFn
    });
    return res.data;
  },

  async getSolutions(fetchFn?: typeof fetch): Promise<SolutionListItem[]> {
    const res = await apiRequest<SolutionListItem[]>('/solutions', { fetchFn });
    return res.data;
  },

  async getSolution(slug: string, fetchFn?: typeof fetch): Promise<SolutionDetail> {
    const res = await apiRequest<SolutionDetail>(`/solutions/${slug}`, { fetchFn });
    return res.data;
  },

  async getPage(slug: string, fetchFn?: typeof fetch): Promise<CmsPage> {
    const res = await apiRequest<CmsPage>(`/pages/${slug}`, { fetchFn });
    return res.data;
  },

  async search(query: string, fetchFn?: typeof fetch): Promise<SearchResults> {
    const res = await apiRequest<SearchResults>('/search', {
      fetchFn,
      params: { q: query }
    });
    return res.data;
  },

  async submitInquiry(
    payload: InquiryPayload,
    fetchFn?: typeof fetch
  ): Promise<ApiResponse<InquiryResponse>> {
    return apiRequest<InquiryResponse>('/inquiries', {
      method: 'POST',
      body: JSON.stringify(payload),
      fetchFn
    });
  }
};
