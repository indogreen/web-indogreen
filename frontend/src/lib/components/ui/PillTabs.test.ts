import { describe, it, expect, vi } from 'vitest';
import { render, screen, fireEvent } from '@testing-library/svelte';
import PillTabs from './PillTabs.svelte';

describe('PillTabs Component', () => {
	const sampleTabs = [
		{ id: 'tab1', label: 'SEMUA' },
		{ id: 'tab2', label: 'TWO-IN-ONE' },
		{ id: 'tab3', label: 'ALL-IN-ONE', disabled: true }
	];

	it('renders tabs inside a tablist with correct roles and aria attributes', () => {
		render(PillTabs, {
			props: {
				tabs: sampleTabs,
				activeTab: 'tab1'
			}
		});

		expect(screen.getByRole('tablist')).toBeInTheDocument();
		const tab1 = screen.getByRole('tab', { name: 'SEMUA' });
		const tab2 = screen.getByRole('tab', { name: 'TWO-IN-ONE' });
		const tab3 = screen.getByRole('tab', { name: 'ALL-IN-ONE' });

		expect(tab1).toHaveAttribute('aria-selected', 'true');
		expect(tab1.className).toContain('bg-ink');
		expect(tab1.className).toContain('text-on-dark');
		expect(tab1.className).toContain('rounded-sm');

		expect(tab2).toHaveAttribute('aria-selected', 'false');
		expect(tab2.className).toContain('bg-transparent');
		expect(tab2.className).toContain('text-ink');

		expect(tab3).toBeDisabled();
	});

	it('switches active tab when clicked and triggers onchange', async () => {
		const handleChange = vi.fn();
		render(PillTabs, {
			props: {
				tabs: sampleTabs,
				activeTab: 'tab1',
				onchange: handleChange
			}
		});

		const tab2 = screen.getByRole('tab', { name: 'TWO-IN-ONE' });
		await fireEvent.click(tab2);

		expect(handleChange).toHaveBeenCalledWith('tab2');
	});
});
