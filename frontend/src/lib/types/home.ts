import type { MediaUrls } from './api.js';
import type { ProductListItem, ProductCategory } from './product.js';
import type { SolutionListItem } from './solution.js';
import type { SiteSettings } from './settings.js';

export interface HeroSlide {
  id: number;
  title: string;
  subtitle?: string | null;
  button_text?: string | null;
  button_url?: string | null;
  desktop_image?: MediaUrls | null;
  mobile_image?: MediaUrls | null;
  sort_order: number;
}

export interface HomeData {
  hero_slides: HeroSlide[];
  featured_products: ProductListItem[];
  solutions: SolutionListItem[];
  categories: ProductCategory[];
  company: SiteSettings;
}
