import { describe, it, expect } from 'vitest';
import { render, screen } from '@testing-library/svelte';
import ProductCard from './ProductCard.svelte';
import FeatureCard from './FeatureCard.svelte';
import ResourceCard from './ResourceCard.svelte';
import CalloutStat from './CalloutStat.svelte';

describe('Card Components', () => {
  describe('ProductCard', () => {
    it('renders product card with title, category, description, and link', () => {
      render(ProductCard, {
        props: {
          title: 'Helios 120W TIO',
          category: 'PJU TWO-IN-ONE',
          description: 'Lampu PJU bertenaga surya efisiensi tinggi',
          href: '/produk/helios-120w',
          ctaText: 'Pelajari Produk'
        }
      });

      expect(screen.getByText('Helios 120W TIO')).toBeInTheDocument();
      expect(screen.getByText('PJU TWO-IN-ONE')).toBeInTheDocument();
      expect(screen.getByText('Lampu PJU bertenaga surya efisiensi tinggi')).toBeInTheDocument();
      const link = screen.getByRole('link', { name: /Pelajari Produk/ });
      expect(link).toHaveAttribute('href', '/produk/helios-120w');
    });
  });

  describe('FeatureCard', () => {
    it('renders title, description and icon', () => {
      render(FeatureCard, {
        props: {
          title: 'Baterai LiFePO4',
          description: 'Siklus hidup lebih dari 3000 cycle',
          icon: 'battery-charging',
          hasCornerSquare: true
        }
      });

      expect(screen.getByText('Baterai LiFePO4')).toBeInTheDocument();
      expect(screen.getByText('Siklus hidup lebih dari 3000 cycle')).toBeInTheDocument();
    });
  });

  describe('ResourceCard', () => {
    it('renders badge label, title, description, and cta', () => {
      render(ResourceCard, {
        props: {
          typeLabel: 'BROSUR TEKNIS',
          title: 'Katalog PJU 2026',
          description: 'Dokumen spesifikasi lengkap',
          href: '/resources/katalog-2026.pdf',
          ctaText: 'Unduh Brosur'
        }
      });

      expect(screen.getByText('BROSUR TEKNIS')).toBeInTheDocument();
      expect(screen.getByText('Katalog PJU 2026')).toBeInTheDocument();
      expect(screen.getByRole('link', { name: /Unduh Brosur/ })).toHaveAttribute(
        'href',
        '/resources/katalog-2026.pdf'
      );
    });
  });

  describe('CalloutStat', () => {
    it('renders numeric value, unit, caption, and optional label', () => {
      render(CalloutStat, {
        props: {
          label: 'KAPASITAS TOTAL',
          value: '2.500',
          unit: 'kWp',
          caption: 'Total daya PLTS terpasang'
        }
      });

      expect(screen.getByText('KAPASITAS TOTAL')).toBeInTheDocument();
      expect(screen.getByText('2.500')).toBeInTheDocument();
      expect(screen.getByText('kWp')).toBeInTheDocument();
      expect(screen.getByText('Total daya PLTS terpasang')).toBeInTheDocument();
    });
  });
});
