import { describe, it, expect } from 'vitest';
import { render, screen } from '@testing-library/svelte';
import Badge from './Badge.svelte';

describe('Badge Component', () => {
	it('renders default variant with caption-md uppercase typography', () => {
		render(Badge, {
			props: {
				text: 'WHITE PAPER'
			}
		});

		const badge = screen.getByText('WHITE PAPER');
		expect(badge).toBeInTheDocument();
		expect(badge.className).toContain('type-caption-md');
		expect(badge.className).toContain('uppercase');
		expect(badge.className).toContain('bg-surface-soft');
		expect(badge.className).toContain('text-body');
		expect(badge.className).toContain('rounded-sm');
	});

	it('renders primary variant', () => {
		render(Badge, {
			props: {
				variant: 'primary',
				text: 'SOLAR PV'
			}
		});

		const badge = screen.getByText('SOLAR PV');
		expect(badge.className).toContain('bg-primary');
		expect(badge.className).toContain('text-on-primary');
	});

	it('renders dark and outline variants', () => {
		const { container } = render(Badge, {
			props: {
				variant: 'dark',
				text: 'OFF-GRID'
			}
		});

		const badge = container.querySelector('span');
		expect(badge?.className).toContain('bg-surface-elevated');
		expect(badge?.className).toContain('text-on-dark');
	});
});
