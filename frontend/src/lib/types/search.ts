export interface SearchResultItem {
  id: number;
  name: string;
  slug: string;
  category_slug?: string;
}

export interface SearchResults {
  products: SearchResultItem[];
  solutions: SearchResultItem[];
  categories: SearchResultItem[];
}
