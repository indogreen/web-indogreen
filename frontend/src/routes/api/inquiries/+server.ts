import { json } from '@sveltejs/kit';
import type { RequestHandler } from './$types';
import { api, ApiClientError } from '$lib/server/api';
import type { InquiryPayload } from '$lib/types';

export const POST: RequestHandler = async ({ request, fetch }) => {
  try {
    const body = (await request.json()) as Partial<InquiryPayload>;

    const fullName = body.full_name?.trim();
    const email = body.email?.trim();
    const subject = body.subject?.trim();
    const messageContent = body.message_content?.trim();

    // Basic frontend-level validation
    const errors: Record<string, string[]> = {};
    if (!fullName) {
      errors.full_name = ['Nama lengkap wajib diisi.'];
    }
    if (!email || !email.includes('@')) {
      errors.email = ['Alamat email tidak valid.'];
    }
    if (!subject) {
      errors.subject = ['Subjek permohonan wajib diisi.'];
    }
    if (!messageContent) {
      errors.message_content = ['Pesan kebutuhan atau permohonan wajib diisi.'];
    }
    if (body.consent !== true) {
      errors.consent = ['Persetujuan pemrosesan data wajib disetujui.'];
    }

    if (Object.keys(errors).length > 0 || !fullName || !email || !subject || !messageContent) {
      return json(
        {
          success: false,
          message: 'Data yang dikirimkan tidak valid.',
          error_code: 'VALIDATION_ERROR',
          errors
        },
        { status: 422 }
      );
    }

    const payload: InquiryPayload = {
      full_name: fullName,
      email: email,
      phone_whatsapp: body.phone_whatsapp?.trim() || undefined,
      company_organization: body.company_organization?.trim() || undefined,
      product_slug: body.product_slug?.trim() || null,
      solution_slug: body.solution_slug?.trim() || null,
      subject: subject,
      message_content: messageContent,
      consent: true,
      website_url: body.website_url || ''
    };

    const apiResponse = await api.submitInquiry(payload, fetch);
    return json(apiResponse, { status: 201 });
  } catch (err: unknown) {
    if (err instanceof ApiClientError) {
      return json(
        {
          success: false,
          message: err.message,
          error_code: err.errorCode || 'API_ERROR',
          errors: err.errors || {}
        },
        { status: err.status }
      );
    }

    return json(
      {
        success: false,
        message: 'Terjadi gangguan internal saat memproses permohonan konsultasi.',
        error_code: 'INTERNAL_SERVER_ERROR',
        errors: {}
      },
      { status: 500 }
    );
  }
};
