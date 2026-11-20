import { dev } from '$app/env';
import { error } from '@sveltejs/kit';
import type { PageServerLoad } from './$types';

export const load: PageServerLoad = () => {
  // Dev-only route: completely disabled in production environments
  if (!dev) {
    error(
      404,
      'Halaman styleguide hanya tersedia pada lingkungan pengembangan (development mode).'
    );
  }

  return {
    title: 'INDOGREEN Design System Styleguide',
    description:
      'Verifikasi visual token desain dan pustaka komponen antarmuka resmi PT. Indogreen Technology And Management'
  };
};
