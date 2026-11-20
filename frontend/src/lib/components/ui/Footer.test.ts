import { describe, it, expect } from 'vitest';
import { render, screen, fireEvent } from '@testing-library/svelte';
import Footer from './Footer.svelte';

describe('Footer Component', () => {
  it('renders four column headers: Produk, Solusi, Perusahaan, Kontak', () => {
    render(Footer);

    expect(screen.getByTestId('footer-accordion-produk')).toBeInTheDocument();
    expect(screen.getByTestId('footer-accordion-solusi')).toBeInTheDocument();
    expect(screen.getByTestId('footer-accordion-perusahaan')).toBeInTheDocument();
    expect(screen.getByTestId('footer-accordion-kontak')).toBeInTheDocument();
  });

  it('renders official logo, automatic current year, and exact company name', () => {
    render(Footer);

    const logo = screen.getByAltText('PT. Indogreen Technology And Management');
    expect(logo).toBeInTheDocument();
    expect(logo).toHaveAttribute('src', '/indogreen.png');

    const currentYear = new Date().getFullYear();
    const copyrightRegex = new RegExp(
      `Copyright © ${currentYear} PT\\. Indogreen Technology And Management`
    );
    expect(screen.getByText(copyrightRegex)).toBeInTheDocument();

    expect(screen.getByText('Privacy Policy')).toBeInTheDocument();
    expect(screen.getByText('Terms of Service')).toBeInTheDocument();
    expect(screen.getByText('Accessibility')).toBeInTheDocument();
    expect(screen.getByText('Product Security')).toBeInTheDocument();
  });

  it('toggles mobile accordion sections via click and keyboard', async () => {
    render(Footer);

    const produkBtn = screen.getByTestId('footer-accordion-produk');
    expect(produkBtn).toHaveAttribute('aria-expanded', 'false');

    const produkCol = document.getElementById('footer-col-produk');
    expect(produkCol).toHaveClass('hidden');

    // Click to expand
    await fireEvent.click(produkBtn);
    expect(produkBtn).toHaveAttribute('aria-expanded', 'true');
    expect(produkCol).toHaveClass('block');

    // Click again to collapse
    await fireEvent.click(produkBtn);
    expect(produkBtn).toHaveAttribute('aria-expanded', 'false');
    expect(produkCol).toHaveClass('hidden');
  });

  it('renders newsletter subscription form and handles submit', async () => {
    render(Footer);

    const emailInput = screen.getByLabelText('Alamat email buletin');
    expect(emailInput).toBeInTheDocument();

    const subscribeBtn = screen.getByRole('button', { name: 'Subscribe' });
    expect(subscribeBtn).toBeInTheDocument();

    await fireEvent.input(emailInput, { target: { value: 'tender@indogreen.id' } });
    await fireEvent.click(subscribeBtn);

    expect(screen.getByText(/Terima kasih telah berlangganan/)).toBeInTheDocument();
  });

  it('renders all social media link icons', () => {
    render(Footer);

    expect(screen.getByLabelText('Facebook INDOGREEN')).toBeInTheDocument();
    expect(screen.getByLabelText('Instagram INDOGREEN')).toBeInTheDocument();
    expect(screen.getByLabelText('LinkedIn INDOGREEN')).toBeInTheDocument();
    expect(screen.getByLabelText('YouTube INDOGREEN')).toBeInTheDocument();
  });
});
