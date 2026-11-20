export interface SocialLinks {
  facebook?: string | null;
  instagram?: string | null;
  youtube?: string | null;
  twitter?: string | null;
  linkedin?: string | null;
}

export interface Office {
  id: number;
  name: string;
  office_type: string;
  office_type_label: string;
  address: string;
  phone?: string | null;
  email?: string | null;
  map_embed_url?: string | null;
  sort_order: number;
}

export interface SiteSettings {
  company_name: string;
  tagline?: string | null;
  phone?: string | null;
  email?: string | null;
  whatsapp?: string | null;
  head_office_address?: string | null;
  representative_office_address?: string | null;
  social_links?: SocialLinks | null;
  offices?: Office[];
}
