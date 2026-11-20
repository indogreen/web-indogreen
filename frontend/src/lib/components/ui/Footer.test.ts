import { describe, it, expect } from 'vitest';
import { render, screen, fireEvent } from '@testing-library/svelte';
import Footer from './Footer.svelte';

describe('Footer Component', () => {
	it('renders three column headers matching reference specification', () => {
		render(Footer);

		expect(screen.getByText('Company Information')).toBeInTheDocument();
		expect(screen.getByText('News and Events')).toBeInTheDocument();
		expect(screen.getByText('Popular Links')).toBeInTheDocument();
	});

	it('renders official logo and copyright in legal sub-footer', () => {
		render(Footer);

		const logo = screen.getByAltText('Logo Resmi INDOGREEN');
		expect(logo).toBeInTheDocument();
		expect(logo).toHaveAttribute('src', '/indogreen.png');

		expect(screen.getByText(/Copyright © 2026 PT. Indogreen/)).toBeInTheDocument();
		expect(screen.getByText('Privacy Policy')).toBeInTheDocument();
		expect(screen.getByText('Terms of Service')).toBeInTheDocument();
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
		expect(screen.getByLabelText('X (formerly Twitter) INDOGREEN')).toBeInTheDocument();
		expect(screen.getByLabelText('YouTube INDOGREEN')).toBeInTheDocument();
	});
});
