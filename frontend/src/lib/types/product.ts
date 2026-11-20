import type { MediaUrls } from './api.js';

export interface ProductSpecification {
  key: string;
  value: string;
  unit?: string | null;
}

export interface ProductCategory {
  id: number;
  name: string;
  slug: string;
  description?: string | null;
  icon_name?: string | null;
  sort_order: number;
  products_count?: number;
  image?: MediaUrls | null;
}

export interface ProductListItem {
  id: number;
  name: string;
  slug: string;
  category_slug: string;
  category_name: string;
  model_series?: string | null;
  badge_tag?: string | null;
  short_description?: string | null;
  featured_image?: MediaUrls | null;
  datasheet_pdf_url?: string | null;
  is_featured: boolean;
  sort_order: number;
}

export interface ProductDetail extends ProductListItem {
  full_description?: string | null;
  category: {
    id: number;
    name: string;
    slug: string;
  };
  specifications_grouped?: Record<string, ProductSpecification[]>;
  gallery?: MediaUrls[];
  solutions?: Array<{
    id: number;
    name: string;
    slug: string;
    system_type?: string | null;
  }>;
  seo_title?: string | null;
  seo_description?: string | null;
}
