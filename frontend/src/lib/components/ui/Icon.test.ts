import { describe, it, expect } from 'vitest';
import { render } from '@testing-library/svelte';
import Icon from './Icon.svelte';

describe('Icon Component', () => {
  it('renders Lucide SVG icon with default stroke width', () => {
    const { container } = render(Icon, {
      props: {
        name: 'arrow-right'
      }
    });

    const svg = container.querySelector('svg');
    expect(svg).toBeInTheDocument();
    expect(svg).toHaveAttribute('aria-hidden', 'true');
  });

  it('renders with accessible ariaLabel', () => {
    const { container } = render(Icon, {
      props: {
        name: 'sun',
        ariaLabel: 'Ikon Matahari Energi Surya'
      }
    });

    const svg = container.querySelector('svg');
    expect(svg).toHaveAttribute('aria-label', 'Ikon Matahari Energi Surya');
    expect(svg).toHaveAttribute('role', 'img');
    expect(svg).not.toHaveAttribute('aria-hidden');
  });
});
