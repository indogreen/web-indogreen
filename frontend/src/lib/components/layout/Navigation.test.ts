import { describe, it, expect, vi, beforeEach } from 'vitest';
import { render, screen, fireEvent } from '@testing-library/svelte';
import PrimaryNav from './PrimaryNav.svelte';
import MobileDrawer from './MobileDrawer.svelte';

describe('Navigation Components', () => {
  beforeEach(() => {
    document.body.style.overflow = '';
  });

  describe('PrimaryNav Component', () => {
    it('renders logo, desktop navigation menu items, search button, and single green CTA', () => {
      render(PrimaryNav, { currentPath: '/' });

      // Official Logo
      const logo = screen.getByAltText('PT. Indogreen Technology And Management');
      expect(logo).toBeInTheDocument();

      // Desktop Nav Links
      expect(screen.getByText('Beranda')).toBeInTheDocument();
      expect(screen.getByText('Produk')).toBeInTheDocument();
      expect(screen.getByText('Solusi')).toBeInTheDocument();
      expect(screen.getByText('Tentang Kami')).toBeInTheDocument();
      expect(screen.getByText('Kontak')).toBeInTheDocument();

      // Search button
      const searchBtn = screen.getByTestId('nav-search-btn');
      expect(searchBtn).toBeInTheDocument();
      expect(searchBtn).toHaveAttribute('href', '/pencarian');

      // Exactly ONE solid green CTA per viewport
      const contactCta = screen.getByTestId('nav-contact-cta');
      expect(contactCta).toBeInTheDocument();
      expect(contactCta).toHaveTextContent('Hubungi Kami');
      expect(contactCta).toHaveAttribute('href', '/kontak');
    });

    it('marks the active navigation item with aria-current="page"', () => {
      render(PrimaryNav, { currentPath: '/produk' });

      const produkLinks = screen.getAllByRole('link', { name: 'Produk' });
      // Desktop link should have aria-current="page"
      const desktopActiveLink = produkLinks.find(
        (el) => el.getAttribute('aria-current') === 'page'
      );
      expect(desktopActiveLink).toBeDefined();

      const berandaLinks = screen.getAllByRole('link', { name: 'Beranda' });
      const berandaActive = berandaLinks.find((el) => el.getAttribute('aria-current') === 'page');
      expect(berandaActive).toBeUndefined();
    });

    it('toggles mobile drawer when hamburger button is clicked', async () => {
      render(PrimaryNav, { currentPath: '/' });

      const toggleBtn = screen.getByTestId('drawer-toggle-btn');
      expect(toggleBtn).toHaveAttribute('aria-expanded', 'false');

      await fireEvent.click(toggleBtn);

      expect(screen.getByTestId('mobile-drawer')).toBeInTheDocument();
      expect(toggleBtn).toHaveAttribute('aria-expanded', 'true');
    });
  });

  describe('MobileDrawer Component', () => {
    it('renders drawer navigation links when isOpen is true', () => {
      const onClose = vi.fn();
      render(MobileDrawer, { isOpen: true, onClose, currentPath: '/solusi' });

      const drawer = screen.getByTestId('mobile-drawer');
      expect(drawer).toBeInTheDocument();
      expect(drawer).toHaveAttribute('role', 'dialog');
      expect(drawer).toHaveAttribute('aria-modal', 'true');

      expect(screen.getByRole('link', { name: 'Pencarian Produk & Solusi' })).toBeInTheDocument();
      expect(screen.getByRole('link', { name: 'Hubungi Kami' })).toBeInTheDocument();
    });

    it('locks body scroll when open and restores it when closed', async () => {
      const onClose = vi.fn();
      const { rerender } = render(MobileDrawer, { isOpen: true, onClose });

      expect(document.body.style.overflow).toBe('hidden');

      await rerender({ isOpen: false, onClose });
      expect(document.body.style.overflow).toBe('');
    });

    it('calls onClose when close button or backdrop is clicked', async () => {
      const onClose = vi.fn();
      render(MobileDrawer, { isOpen: true, onClose });

      const closeBtn = screen.getByTestId('drawer-close-btn');
      await fireEvent.click(closeBtn);
      expect(onClose).toHaveBeenCalledTimes(1);

      const backdrop = screen.getByTestId('drawer-backdrop');
      await fireEvent.click(backdrop);
      expect(onClose).toHaveBeenCalledTimes(2);
    });

    it('closes on Escape key press', async () => {
      const onClose = vi.fn();
      render(MobileDrawer, { isOpen: true, onClose });

      await fireEvent.keyDown(window, { key: 'Escape' });
      expect(onClose).toHaveBeenCalledTimes(1);
    });
  });
});
