import { describe, it, expect } from 'vitest';
import { render, screen } from '@testing-library/svelte';
import { createRawSnippet } from 'svelte';
import Container from './Container.svelte';
import Section from './Section.svelte';

describe('Layout Components', () => {
	it('renders Container with container-max class', () => {
		const snippet = createRawSnippet(() => ({
			render: () => '<span data-testid="container-child">Konten Kontainer</span>'
		}));

		const { container } = render(Container, {
			props: {
				children: snippet
			}
		});

		expect(screen.getByTestId('container-child')).toBeInTheDocument();
		const wrapper = container.querySelector('div');
		expect(wrapper?.className).toContain('container-max');
	});

	it('renders Section with light tone by default', () => {
		const { container } = render(Section);
		const sec = container.querySelector('section');
		expect(sec).toBeInTheDocument();
		expect(sec?.className).toContain('bg-canvas');
		expect(sec?.className).toContain('text-ink');
		expect(sec?.className).toContain('section-padding');
	});

	it('renders Section with dark tone and custom id', () => {
		const { container } = render(Section, {
			props: {
				tone: 'dark',
				id: 'hero-section'
			}
		});

		const sec = container.querySelector('section');
		expect(sec).toHaveAttribute('id', 'hero-section');
		expect(sec?.className).toContain('bg-surface-dark');
		expect(sec?.className).toContain('text-on-dark');
	});
});
