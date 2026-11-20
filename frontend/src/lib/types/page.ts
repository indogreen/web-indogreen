export interface CmsPage {
  id: number;
  title: string;
  slug: string;
  content: string;
  seo_title?: string | null;
  seo_description?: string | null;
  updated_at?: string | null;
}
