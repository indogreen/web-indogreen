import { describe, it, expect, vi } from 'vitest';
import { render, screen, fireEvent } from '@testing-library/svelte';
import { createRawSnippet } from 'svelte';
import Button from './Button.svelte';

describe('Button Component', () => {
	it('renders with default primary variant and md size', () => {
		render(Button, {
			props: {
				text: 'Klik Di Sini'
			}
		});

		const btn = screen.getByRole('button', { name: 'Klik Di Sini' });
		expect(btn).toBeInTheDocument();
		expect(btn.className).toContain('bg-primary');
		expect(btn.className).toContain('text-on-primary');
		expect(btn.className).toContain('rounded-sm');
		expect(btn.className).toContain('type-button-md');
	});

	it('renders as a link when href is provided', () => {
		render(Button, {
			props: {
				href: '/kontak',
				text: 'Hubungi Kami'
			}
		});

		const link = screen.getByRole('link', { name: 'Hubungi Kami' });
		expect(link).toBeInTheDocument();
		expect(link).toHaveAttribute('href', '/kontak');
	});

	it('renders disabled state correctly', () => {
		render(Button, {
			props: {
				disabled: true,
				text: 'Tombol Non-Aktif'
			}
		});

		const btn = screen.getByRole('button', { name: 'Tombol Non-Aktif' });
		expect(btn).toBeDisabled();
		expect(btn).toHaveAttribute('aria-disabled', 'true');
		expect(btn.className).toContain('cursor-not-allowed');
		expect(btn.className).toContain('text-ash');
	});

	it('renders outline and outline-on-dark variants', () => {
		const { container } = render(Button, {
			props: {
				variant: 'outline',
				text: 'Outline Button'
			}
		});

		const btn = container.querySelector('button');
		expect(btn?.className).toContain('border-2');
		expect(btn?.className).toContain('border-primary');
		expect(btn?.className).toContain('text-ink');
	});

	it('renders ghost-link variant with rounded-none', () => {
		const { container } = render(Button, {
			props: {
				variant: 'ghost-link',
				text: 'Ghost Link'
			}
		});

		const btn = container.querySelector('button');
		expect(btn?.className).toContain('rounded-none');
		expect(btn?.className).toContain('text-primary');
	});

	it('executes onclick handler when clicked', async () => {
		const handleClick = vi.fn();
		render(Button, {
			props: {
				onclick: handleClick,
				text: 'Interaktif'
			}
		});

		const btn = screen.getByRole('button', { name: 'Interaktif' });
		await fireEvent.click(btn);
		expect(handleClick).toHaveBeenCalledTimes(1);
	});

	it('renders children snippet when provided', () => {
		const snippet = createRawSnippet(() => ({
			render: () => '<span data-testid="custom-child">Kustom Anak</span>'
		}));

		render(Button, {
			props: {
				children: snippet
			}
		});

		expect(screen.getByTestId('custom-child')).toBeInTheDocument();
	});
});
