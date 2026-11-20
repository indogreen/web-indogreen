import { describe, it, expect, vi, beforeEach } from 'vitest';
import { api, apiRequest, ApiClientError, DEFAULT_SITE_SETTINGS } from './api';

describe('Server-only API Client', () => {
  beforeEach(() => {
    vi.restoreAllMocks();
  });

  it('performs successful GET request and returns data and meta', async () => {
    const mockData = { id: 1, name: 'PJU Two-In-One Helios' };
    const mockMeta = { current_page: 1, last_page: 1, per_page: 12, total: 1 };

    const mockFetch = vi.fn().mockResolvedValue({
      ok: true,
      status: 200,
      headers: new Headers({ 'content-type': 'application/json' }),
      json: () =>
        Promise.resolve({
          success: true,
          message: 'Data berhasil diambil.',
          data: mockData,
          meta: mockMeta
        })
    });

    const result = await apiRequest('/products', { fetchFn: mockFetch });

    expect(mockFetch).toHaveBeenCalledTimes(1);
    const calledUrl = String(mockFetch.mock.calls[0][0]);
    expect(calledUrl).toContain('/products');
    expect(result.success).toBe(true);
    expect(result.data).toEqual(mockData);
    expect(result.meta).toEqual(mockMeta);
  });

  it('correctly appends query parameters to URL', async () => {
    const mockFetch = vi.fn().mockResolvedValue({
      ok: true,
      status: 200,
      headers: new Headers({ 'content-type': 'application/json' }),
      json: () => Promise.resolve({ success: true, message: 'OK', data: [] })
    });

    await api.getProducts({ category: 'pju-tenaga-surya', search: 'helios', page: 2 }, mockFetch);

    expect(mockFetch).toHaveBeenCalledTimes(1);
    const calledUrl = String(mockFetch.mock.calls[0][0]);
    expect(calledUrl).toContain('category=pju-tenaga-surya');
    expect(calledUrl).toContain('q=helios');
    expect(calledUrl).toContain('page=2');
  });

  it('performs POST request with json stringified body and correct headers', async () => {
    const payload = {
      full_name: 'Ir. Budi',
      email: 'budi@example.com',
      subject: 'Penawaran 50 unit',
      message_content: 'Kebutuhan tender jalan',
      consent: true
    };

    const mockFetch = vi.fn().mockResolvedValue({
      ok: true,
      status: 201,
      headers: new Headers({ 'content-type': 'application/json' }),
      json: () =>
        Promise.resolve({
          success: true,
          message: 'Permohonan berhasil dikirim.',
          data: { inquiry_id: 123, received_at: '2026-11-20T10:00:00Z' }
        })
    });

    const result = await api.submitInquiry(payload, mockFetch);

    expect(mockFetch).toHaveBeenCalledTimes(1);
    const callArgs = mockFetch.mock.calls[0];
    const options = callArgs[1] as RequestInit;
    expect(options.method).toBe('POST');
    const headers = options.headers as Headers;
    expect(headers.get('Content-Type')).toBe('application/json');
    expect(JSON.parse(options.body as string)).toEqual(payload);
    expect(result.data.inquiry_id).toBe(123);
  });

  it('throws ApiClientError with status 404 and RESOURCE_NOT_FOUND code', async () => {
    const mockFetch = vi.fn().mockResolvedValue({
      ok: false,
      status: 404,
      headers: new Headers({ 'content-type': 'application/json' }),
      json: () =>
        Promise.resolve({
          success: false,
          message: 'Produk tidak ditemukan.',
          error_code: 'RESOURCE_NOT_FOUND',
          errors: {}
        })
    });

    await expect(api.getProduct('pju', 'tidak-ada', mockFetch)).rejects.toThrow(ApiClientError);

    try {
      await api.getProduct('pju', 'tidak-ada', mockFetch);
    } catch (err: unknown) {
      expect(err).toBeInstanceOf(ApiClientError);
      const apiErr = err as ApiClientError;
      expect(apiErr.status).toBe(404);
      expect(apiErr.errorCode).toBe('RESOURCE_NOT_FOUND');
      expect(apiErr.message).toBe('Produk tidak ditemukan.');
    }
  });

  it('throws ApiClientError with status 422 and validation errors map', async () => {
    const mockFetch = vi.fn().mockResolvedValue({
      ok: false,
      status: 422,
      headers: new Headers({ 'content-type': 'application/json' }),
      json: () =>
        Promise.resolve({
          success: false,
          message: 'Data yang dikirimkan tidak valid.',
          error_code: 'VALIDATION_ERROR',
          errors: {
            email: ['Format alamat email tidak valid.'],
            consent: ['Persetujuan pemrosesan data wajib disetujui.']
          }
        })
    });

    try {
      await api.submitInquiry(
        {
          full_name: 'Budi',
          email: 'invalid-email',
          subject: 'Test',
          message_content: 'Test',
          consent: false
        },
        mockFetch
      );
      expect.fail('Should have thrown ApiClientError');
    } catch (err: unknown) {
      expect(err).toBeInstanceOf(ApiClientError);
      const apiErr = err as ApiClientError;
      expect(apiErr.status).toBe(422);
      expect(apiErr.errorCode).toBe('VALIDATION_ERROR');
      expect(apiErr.errors?.email).toContain('Format alamat email tidak valid.');
      expect(apiErr.errors?.consent).toContain('Persetujuan pemrosesan data wajib disetujui.');
    }
  });

  it('throws ApiClientError with status 429 when rate limit exceeded', async () => {
    const mockFetch = vi.fn().mockResolvedValue({
      ok: false,
      status: 429,
      headers: new Headers({ 'content-type': 'application/json' }),
      json: () =>
        Promise.resolve({
          success: false,
          message: 'Terlalu banyak permintaan. Silakan tunggu beberapa saat.',
          error_code: 'RATE_LIMIT_EXCEEDED'
        })
    });

    try {
      await apiRequest('/inquiries', { fetchFn: mockFetch, method: 'POST' });
      expect.fail('Should have thrown 429');
    } catch (err: unknown) {
      expect(err).toBeInstanceOf(ApiClientError);
      const apiErr = err as ApiClientError;
      expect(apiErr.status).toBe(429);
      expect(apiErr.errorCode).toBe('RATE_LIMIT_EXCEEDED');
    }
  });

  it('throws ApiClientError with status 500 when backend returns server error', async () => {
    const mockFetch = vi.fn().mockResolvedValue({
      ok: false,
      status: 500,
      headers: new Headers({ 'content-type': 'application/json' }),
      json: () =>
        Promise.resolve({
          success: false,
          message: 'Terjadi gangguan internal server.',
          error_code: 'INTERNAL_SERVER_ERROR'
        })
    });

    try {
      await apiRequest('/home', { fetchFn: mockFetch });
      expect.fail('Should have thrown 500');
    } catch (err: unknown) {
      expect(err).toBeInstanceOf(ApiClientError);
      const apiErr = err as ApiClientError;
      expect(apiErr.status).toBe(500);
    }
  });

  it('handles abort timeout gracefully with status 504', async () => {
    const mockFetch = vi.fn().mockImplementation(() => {
      const abortErr = new Error('The operation was aborted');
      abortErr.name = 'AbortError';
      return Promise.reject(abortErr);
    });

    try {
      await apiRequest('/home', { fetchFn: mockFetch, timeoutMs: 50 });
      expect.fail('Should have timed out');
    } catch (err: unknown) {
      expect(err).toBeInstanceOf(ApiClientError);
      const apiErr = err as ApiClientError;
      expect(apiErr.status).toBe(504);
      expect(apiErr.errorCode).toBe('GATEWAY_TIMEOUT');
    }
  });

  it('getSettings falls back to DEFAULT_SITE_SETTINGS when backend is down', async () => {
    const mockFetch = vi.fn().mockRejectedValue(new Error('ECONNREFUSED'));

    const settings = await api.getSettings(mockFetch);

    expect(settings).toBeDefined();
    expect(settings.company_name).toBe(DEFAULT_SITE_SETTINGS.company_name);
    expect(settings.email).toBe(DEFAULT_SITE_SETTINGS.email);
    expect(settings.offices).toBeDefined();
    expect(settings.offices?.length).toBeGreaterThan(0);
  });
});
