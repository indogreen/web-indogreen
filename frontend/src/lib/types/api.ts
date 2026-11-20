export interface ApiResponse<T> {
  success: boolean;
  message: string;
  data: T;
  meta?: ApiMeta | null;
}

export interface ApiErrorResponse {
  success: false;
  message: string;
  error_code?: string;
  errors?: Record<string, string[]>;
}

export interface ApiMeta {
  current_page?: number;
  last_page?: number;
  per_page?: number;
  total?: number;
}

export interface MediaUrls {
  original: string;
  thumb?: string;
  card?: string;
  hero?: string;
  alt?: string;
}
