import { describe, it, expect } from 'vitest';
import { render, screen } from '@testing-library/svelte';
import HomePage from './+page.svelte';
import ProductsPage from './produk/+page.svelte';
import ProductDetailPage from './produk/[category]/[slug]/+page.svelte';
import SolutionsPage from './solusi/+page.svelte';
import SolutionDetailPage from './solusi/[slug]/+page.svelte';
import type { HomeData, ProductDetail, SolutionDetail } from '$lib/types/index.js';
import { DEFAULT_SITE_SETTINGS } from '$lib/server/api.js';

describe('Frontend Page Components (Phase 7)', () => {
  describe('Home Page (+page.svelte)', () => {
    const mockHomeData: HomeData = {
      hero_slides: [
        {
          id: 1,
          title: 'Lampu PJU Tenaga Surya Berkualitas Tinggi',
          subtitle: 'Efisiensi maksimal dengan baterai LiFePO4',
          button_text: 'Lihat Katalog Produk',
          button_url: '/produk',
          desktop_image: {
            original: '/images/hero-placeholder.svg',
            thumb: '/images/hero-placeholder.svg',
            card: '/images/hero-placeholder.svg',
            hero: '/images/hero-placeholder.svg',
            alt: 'Hero Desktop'
          },
          mobile_image: null,
          sort_order: 1
        },
        {
          id: 2,
          title: 'Pembangkit Listrik Atap Surya Residensial',
          subtitle: 'Mandiri energi dan hemat tagihan harian',
          button_text: 'Pelajari Solusi',
          button_url: '/solusi',
          desktop_image: null,
          mobile_image: null,
          sort_order: 2
        }
      ],
      featured_products: [],
      solutions: [
        {
          id: 1,
          name: 'PLTS On-Grid System',
          slug: 'plts-on-grid',
          system_type: 'On-Grid',
          summary: 'Sistem atap tersambung PLN.',
          diagram_image: null,
          sort_order: 1
        }
      ],
      categories: [
        {
          id: 1,
          name: 'PJU Tenaga Surya',
          slug: 'pju-tenaga-surya',
          description: 'Lampu jalan mandiri hemat daya.',
          icon_name: 'sun',
          sort_order: 1,
          products_count: 4,
          image: null
        }
      ],
      company: {
        company_name: 'PT. INDOGREEN TECHNOLOGY AND MANAGEMENT',
        tagline: 'SOLAR ENERGY COMPANY / Konsentrasi kami adalah energy ramah lingkungan',
        phone: '+62 251 754 1234',
        email: 'marketing@indogreen.id',
        whatsapp: '+62 811 1234 5678',
        head_office_address: 'Kota Bogor',
        representative_office_address: 'Kota Bandung',
        social_links: {},
        offices: []
      }
    };

    it('renders single H1 hero headline, yellow keyword highlight, and primary CTA', () => {
      render(HomePage, {
        props: {
          data: {
            settings: DEFAULT_SITE_SETTINGS,
            homeData: mockHomeData,
            isApiAvailable: true
          }
        }
      });

      // Verify single H1
      const headings = screen.getAllByRole('heading', { level: 1 });
      expect(headings.length).toBe(1);
      expect(headings[0].textContent).toContain('Lampu PJU');

      // Verify carousel navigation controls because 2 slides exist
      const navToolbar = screen.getByLabelText('Navigasi Slide Banner');
      expect(navToolbar).toBeInTheDocument();

      // Verify CTA button
      const ctaLink = screen.getByRole('link', { name: /Lihat Katalog Produk/i });
      expect(ctaLink).toHaveAttribute('href', '/produk');

      // Verify company profile section
      expect(
        screen.getByRole('heading', {
          name: /Dedikasi untuk Kemandirian Energi Bersih Indonesia/i
        })
      ).toBeInTheDocument();

      // Verify categories grid
      expect(screen.getByText('PJU Tenaga Surya')).toBeInTheDocument();

      // Verify CTA Strip
      expect(
        screen.getByRole('heading', {
          name: /Siap Membangun Sistem Energi Surya Anda\?/i
        })
      ).toBeInTheDocument();
    });

    it('renders static hero without carousel controls when only one slide is active', () => {
      const singleSlideData: HomeData = {
        ...mockHomeData,
        hero_slides: [mockHomeData.hero_slides[0]]
      };

      render(HomePage, {
        props: {
          data: {
            settings: DEFAULT_SITE_SETTINGS,
            homeData: singleSlideData,
            isApiAvailable: true
          }
        }
      });

      // Toolbar controls must not be rendered
      expect(screen.queryByLabelText('Navigasi Slide Banner')).toBeNull();
    });
  });

  describe('Products Catalog Page (produk/+page.svelte)', () => {
    it('renders category PillTabs, product cards, and single H1', () => {
      render(ProductsPage, {
        props: {
          data: {
            settings: DEFAULT_SITE_SETTINGS,
            categories: [
              {
                id: 1,
                name: 'PJU Tenaga Surya',
                slug: 'pju-tenaga-surya',
                sort_order: 1
              }
            ],
            products: [
              {
                id: 1,
                name: 'PJU Two-In-One Helios 60W',
                slug: 'pju-two-in-one-helios-60w',
                category_slug: 'pju-tenaga-surya',
                category_name: 'PJU Tenaga Surya',
                short_description: 'Lampu jalan mandiri baterai LiFePO4',
                badge_tag: 'Best Seller',
                is_featured: true,
                sort_order: 1
              }
            ],
            meta: { current_page: 1, last_page: 2, per_page: 12, total: 15 },
            selectedCategory: '',
            currentPage: 1
          }
        }
      });

      // Heading 1
      const h1 = screen.getByRole('heading', { level: 1 });
      expect(h1.textContent).toContain('Katalog Produk Tenaga Surya');

      // PillTabs
      expect(screen.getByRole('tab', { name: /Semua Produk/i })).toBeInTheDocument();
      expect(screen.getByRole('tab', { name: /PJU Tenaga Surya/i })).toBeInTheDocument();

      // Product card
      expect(screen.getByText('PJU Two-In-One Helios 60W')).toBeInTheDocument();
      expect(screen.getByText('Best Seller')).toBeInTheDocument();

      // Pagination
      expect(screen.getByLabelText('Paginasi Katalog Produk')).toBeInTheDocument();
    });

    it('renders clean empty state when no products match', () => {
      render(ProductsPage, {
        props: {
          data: {
            settings: DEFAULT_SITE_SETTINGS,
            categories: [],
            products: [],
            meta: null,
            selectedCategory: 'solar-home-system',
            currentPage: 1
          }
        }
      });

      expect(screen.getByTestId('product-empty-state')).toBeInTheDocument();
      expect(screen.getByText(/Tidak Ada Produk Ditemukan/i)).toBeInTheDocument();
    });
  });

  describe('Product Detail Page (produk/[category]/[slug]/+page.svelte)', () => {
    const mockDetail: ProductDetail = {
      id: 1,
      name: 'PJU Two-In-One Helios Series 60W',
      slug: 'pju-two-in-one-helios-series-60w',
      category_slug: 'pju-tenaga-surya',
      category_name: 'PJU Tenaga Surya',
      category: { id: 1, name: 'PJU Tenaga Surya', slug: 'pju-tenaga-surya' },
      model_series: 'Helios',
      badge_tag: 'Best Seller',
      short_description: 'Ringkasan teknis lampu PJU surya mandiri',
      full_description: '<p>Deskripsi komprehensif fitur operasional sistem.</p>',
      featured_image: {
        original: '/images/product-pju-placeholder.svg',
        alt: 'PJU Helios 60W'
      },
      datasheet_pdf_url: '/dummy-assets/datasheet-sample.md',
      specifications_grouped: {
        'Lampu & Optik': [
          { key: 'Daya Lampu', value: '60', unit: 'W' },
          { key: 'Fluks Cahaya', value: '9.600', unit: 'Lumen' }
        ]
      },
      is_featured: true,
      sort_order: 1
    };

    it('renders single H1, gallery, specs table, download button, and CTA Minta Penawaran', () => {
      render(ProductDetailPage, {
        props: {
          data: {
            settings: DEFAULT_SITE_SETTINGS,
            product: mockDetail,
            relatedProducts: []
          }
        }
      });

      // Single H1 with product name
      const h1 = screen.getByRole('heading', { level: 1 });
      expect(h1.textContent).toBe('PJU Two-In-One Helios Series 60W');

      // CTA 'Minta Penawaran' to /kontak?produk=slug
      const quoteButtons = screen.getAllByRole('link', { name: /Minta Penawaran/i });
      expect(quoteButtons[0]).toHaveAttribute(
        'href',
        '/kontak?produk=pju-two-in-one-helios-series-60w'
      );

      // Datasheet download button
      const downloadBtn = screen.getByRole('link', { name: /Unduh Datasheet/i });
      expect(downloadBtn).toHaveAttribute('href', '/dummy-assets/datasheet-sample.md');

      // Specifications table
      expect(screen.getByText('Tabel Spesifikasi Teknis')).toBeInTheDocument();
      expect(screen.getByText('Daya Lampu')).toBeInTheDocument();
      expect(screen.getByText('60')).toBeInTheDocument();
      expect(screen.getByText('W')).toBeInTheDocument();
    });
  });

  describe('Solutions Pages (solusi/+page.svelte & [slug]/+page.svelte)', () => {
    it('renders solutions catalog with FeatureCards and single H1', () => {
      render(SolutionsPage, {
        props: {
          data: {
            settings: DEFAULT_SITE_SETTINGS,
            solutions: [
              {
                id: 1,
                name: 'PLTS On-Grid System',
                slug: 'plts-on-grid',
                system_type: 'On-Grid',
                summary: 'Sistem atap surya hemat tagihan harian PLN.',
                diagram_image: null,
                sort_order: 1
              }
            ]
          }
        }
      });

      const h1 = screen.getByRole('heading', { level: 1 });
      expect(h1.textContent).toContain('Solusi Rekayasa Sistem Energi Surya');

      expect(screen.getByRole('heading', { name: 'PLTS On-Grid System' })).toBeInTheDocument();
      const link = screen.getByRole('link', { name: /Pelajari Arsitektur/i });
      expect(link).toHaveAttribute('href', '/solusi/plts-on-grid');
    });

    it('renders solution detail with architecture body, benefits, and CTA', () => {
      const mockSolutionDetail: SolutionDetail = {
        id: 1,
        name: 'PLTS On-Grid System',
        slug: 'plts-on-grid',
        system_type: 'On-Grid',
        summary: 'Sistem atap tersambung jaringan PLN.',
        system_architecture: '<p>Arus DC dari panel fotovoltaik dialirkan ke inverter.</p>',
        included_components: ['Modul Surya Monocrystalline Tier-1'],
        benefits: ['Memangkas hingga 60% tagihan PLN'],
        products: [],
        sort_order: 1
      };

      render(SolutionDetailPage, {
        props: {
          data: {
            settings: DEFAULT_SITE_SETTINGS,
            solution: mockSolutionDetail
          }
        }
      });

      const h1 = screen.getByRole('heading', { level: 1 });
      expect(h1.textContent).toBe('PLTS On-Grid System');

      // Benefits
      expect(screen.getByText('Memangkas hingga 60% tagihan PLN')).toBeInTheDocument();

      // Included components
      expect(screen.getByText('Modul Surya Monocrystalline Tier-1')).toBeInTheDocument();

      // CTA
      const ctaBtn = screen.getByRole('link', { name: /Konsultasi Proyek Sistem/i });
      expect(ctaBtn).toHaveAttribute('href', '/kontak?solusi=plts-on-grid');
    });
  });
});
