import { describe, it, expect, vi, beforeEach } from 'vitest';
import { POST } from './+server';
import { api, ApiClientError } from '$lib/server/api';

type PostEvent = Parameters<typeof POST>[0];

interface JsonResponse {
  success: boolean;
  message?: string;
  data?: { inquiry_id: number; received_at?: string };
  error_code?: string;
  errors?: Record<string, string[]>;
}

describe('Inquiries Proxy Endpoint (+server.test.ts)', () => {
  beforeEach(() => {
    vi.restoreAllMocks();
  });

  it('returns 422 when required fields are missing or consent is false', async () => {
    const mockRequest = {
      json: () =>
        Promise.resolve({
          full_name: '',
          email: 'invalid-email',
          subject: '',
          message_content: '',
          consent: false
        })
    } as unknown as Request;

    const event = {
      request: mockRequest,
      fetch: vi.fn(),
      url: new URL('http://localhost:3000/api/inquiries')
    } as unknown as PostEvent;

    const response = await POST(event);
    expect(response.status).toBe(422);

    const data = (await response.json()) as JsonResponse;
    expect(data.success).toBe(false);
    expect(data.error_code).toBe('VALIDATION_ERROR');
    expect(data.errors?.full_name).toBeDefined();
    expect(data.errors?.email).toBeDefined();
    expect(data.errors?.consent).toBeDefined();
  });

  it('proxies valid payload to backend API and returns 201', async () => {
    const mockPayload = {
      full_name: 'Ir. Budi Santoso',
      email: 'budi@ptsurya.co.id',
      phone_whatsapp: '+6281234567890',
      subject: 'Penawaran 50 unit PJU',
      message_content: 'Mohon info harga untuk proyek jalan industri',
      consent: true,
      website_url: ''
    };

    vi.spyOn(api, 'submitInquiry').mockResolvedValue({
      success: true,
      message: 'Permohonan konsultasi Anda berhasil dikirimkan.',
      data: { inquiry_id: 42, received_at: '2026-11-20T11:00:00Z' }
    });

    const mockRequest = {
      json: () => Promise.resolve(mockPayload)
    } as unknown as Request;

    const event = {
      request: mockRequest,
      fetch: vi.fn(),
      url: new URL('http://localhost:3000/api/inquiries')
    } as unknown as PostEvent;

    const response = await POST(event);
    expect(response.status).toBe(201);

    const data = (await response.json()) as JsonResponse;
    expect(data.success).toBe(true);
    expect(data.data?.inquiry_id).toBe(42);
  });

  it('handles backend ApiClientError and mirrors error status and payload', async () => {
    vi.spyOn(api, 'submitInquiry').mockRejectedValue(
      new ApiClientError('Batas pengiriman formulir terlampaui.', 429, 'RATE_LIMIT_EXCEEDED')
    );

    const mockRequest = {
      json: () =>
        Promise.resolve({
          full_name: 'Budi',
          email: 'budi@example.com',
          subject: 'Permohonan',
          message_content: 'Pesan',
          consent: true
        })
    } as unknown as Request;

    const event = {
      request: mockRequest,
      fetch: vi.fn(),
      url: new URL('http://localhost:3000/api/inquiries')
    } as unknown as PostEvent;

    const response = await POST(event);
    expect(response.status).toBe(429);

    const data = (await response.json()) as JsonResponse;
    expect(data.success).toBe(false);
    expect(data.error_code).toBe('RATE_LIMIT_EXCEEDED');
  });
});
