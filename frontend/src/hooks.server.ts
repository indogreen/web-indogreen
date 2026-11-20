import type { Handle, HandleServerError } from '@sveltejs/kit/hooks';

/**
 * Kerangka Peta Pengalihan 301 (301 Redirect Map)
 * Diinisialisasi di Fase 6 dan akan diisi lengkap pada Fase 9 berdasarkan docs/06-content-migration.md
 */
const REDIRECT_MAP: Record<string, string> = {
  '/about-us-one.html': '/tentang-kami',
  '/contact-one.html': '/kontak',
  '/product-list.html': '/produk',
  '/services-one.html': '/solusi'
};

export const handle: Handle = async ({ event, resolve }) => {
  const pathname = event.url.pathname;

  // 1. Pemeriksaan Kerangka Redirect Map (301 Permanent Redirect)
  if (REDIRECT_MAP[pathname]) {
    const targetUrl = new URL(REDIRECT_MAP[pathname], event.url.origin).toString();
    return Response.redirect(targetUrl, 301);
  }

  // 2. Eksekusi request melalui SvelteKit
  const response = await resolve(event);

  // 3. Security Headers Dasar (sesuai docs/02-architecture.md)
  response.headers.set('X-Frame-Options', 'SAMEORIGIN');
  response.headers.set('X-Content-Type-Options', 'nosniff');
  response.headers.set('Referrer-Policy', 'strict-origin-when-cross-origin');
  response.headers.set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

  // 4. Cache Headers untuk Aset Statis
  if (pathname.startsWith('/_app/immutable/')) {
    response.headers.set('Cache-Control', 'public, max-age=31536000, immutable');
  } else if (
    pathname.match(/\.(png|jpe?g|svg|webp|ico|woff2?|ttf)$/) ||
    pathname === '/indogreen.png' ||
    pathname === '/robots.txt'
  ) {
    response.headers.set('Cache-Control', 'public, max-age=2592000, stale-while-revalidate=86400');
  }

  return response;
};

/**
 * Penanganan Error Terpusat (Centralized Server Error Handler)
 * Mencegah kebocoran stack trace teknis ke sisi publik
 */
export const handleError: HandleServerError = ({ error, event }) => {
  console.error(`[Server Error] Path: ${event.url.pathname}`, error);

  return {
    message: 'Terjadi gangguan internal pada server.'
  };
};
