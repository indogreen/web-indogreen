import { describe, it, expect } from 'vitest';
import { render, screen } from '@testing-library/svelte';
import Breadcrumb from './Breadcrumb.svelte';
import SubNav from './SubNav.svelte';
import SeoHead from './SeoHead.svelte';

describe('Additional Layout Components', () => {
  describe('Breadcrumb Component', () => {
    it('renders breadcrumb items with Beranda as root and active last item', () => {
      render(Breadcrumb, {
        items: [{ label: 'Produk', href: '/produk' }, { label: 'PJU Tenaga Surya' }]
      });

      expect(screen.getByRole('navigation', { name: 'Breadcrumb' })).toBeInTheDocument();
      expect(screen.getByRole('link', { name: 'Kembali ke Beranda' })).toBeInTheDocument();
      expect(screen.getByRole('link', { name: 'Produk' })).toBeInTheDocument();
      expect(screen.getByText('PJU Tenaga Surya')).toHaveAttribute('aria-current', 'page');
    });

    it('renders nothing when items array is empty', () => {
      const { container } = render(Breadcrumb, { items: [] });
      expect(container.querySelector('nav')).toBeNull();
    });
  });

  describe('SubNav Component', () => {
    const items = [
      { label: 'Semua Produk', href: '/produk', count: 12 },
      { label: 'PJU Surya', href: '/produk/pju-tenaga-surya', count: 4 },
      { label: 'PLTS Atap', href: '/produk/plts-residential', count: 3 }
    ];

    it('renders horizontal items on desktop and select dropdown on mobile', () => {
      render(SubNav, { items, activeHref: '/produk' });

      expect(screen.getByRole('navigation', { name: 'Navigasi Sub-kategori' })).toBeInTheDocument();
      expect(screen.getByRole('combobox')).toBeInTheDocument();

      const activeLink = screen.getAllByRole('link', { name: /Semua Produk/ });
      expect(activeLink.length).toBeGreaterThan(0);
      expect(activeLink[0]).toHaveAttribute('aria-current', 'page');
    });
  });

  describe('SeoHead Component', () => {
    it('formats title with %s | INDOGREEN template', () => {
      render(SeoHead, { title: 'Katalog Produk PJU' });

      expect(document.title).toBe('Katalog Produk PJU | INDOGREEN');
    });

    it('falls back to seoData when props are not provided', () => {
      render(SeoHead, {
        seoData: {
          seo_title: 'Spesifikasi Lampu Helios',
          seo_description: 'Deskripsi teknis helios dari API.'
        }
      });

      expect(document.title).toBe('Spesifikasi Lampu Helios | INDOGREEN');
      const metaDesc = document.querySelector('meta[name="description"]');
      expect(metaDesc?.getAttribute('content')).toBe('Deskripsi teknis helios dari API.');
    });
  });
});
