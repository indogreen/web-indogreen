export interface SeoMetadata {
  title?: string | null;
  description?: string | null;
  canonical?: string | null;
  ogTitle?: string | null;
  ogDescription?: string | null;
  ogImage?: string | null;
  ogType?: string;
  twitterCard?: string;
  robots?: string;
  jsonLd?: Record<string, unknown> | Array<Record<string, unknown>> | null;
}
