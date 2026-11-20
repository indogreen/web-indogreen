import type { MediaUrls } from './api.js';
import type { ProductListItem } from './product.js';

export interface SolutionListItem {
  id: number;
  name: string;
  slug: string;
  system_type: string;
  summary: string;
  diagram_image?: MediaUrls | null;
  sort_order: number;
}

export interface SolutionDetail extends SolutionListItem {
  system_architecture?: string | null;
  included_components?: string[];
  benefits?: string[];
  products?: ProductListItem[];
  seo_title?: string | null;
  seo_description?: string | null;
}
