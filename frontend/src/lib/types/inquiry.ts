export interface InquiryPayload {
  full_name: string;
  email: string;
  phone_whatsapp?: string | null;
  company_organization?: string | null;
  product_slug?: string | null;
  solution_slug?: string | null;
  subject: string;
  message_content: string;
  consent: boolean;
  website_url?: string;
}

export interface InquiryResponse {
  inquiry_id: number;
  received_at: string;
}

export interface InquiryFormErrors {
  full_name?: string[];
  email?: string[];
  phone_whatsapp?: string[];
  company_organization?: string[];
  subject?: string[];
  message_content?: string[];
  consent?: string[];
  [key: string]: string[] | undefined;
}
