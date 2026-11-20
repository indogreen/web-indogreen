import { describe, it, expect } from 'vitest';
import { render } from '@testing-library/svelte';
import CornerSquare from './CornerSquare.svelte';

describe('CornerSquare Component', () => {
  it('renders with top-left position and sm size by default', () => {
    const { container } = render(CornerSquare);

    const square = container.querySelector('div');
    expect(square).toBeInTheDocument();
    expect(square?.className).toContain('bg-primary');
    expect(square?.className).toContain('rounded-none');
    expect(square?.className).toContain('w-corner');
    expect(square?.className).toContain('h-corner');
    expect(square?.className).toContain('absolute');
    expect(square?.className).toContain('top-0');
    expect(square?.className).toContain('left-0');
    expect(square).toHaveAttribute('aria-hidden', 'true');
  });

  it('renders with bottom-right position and lg size', () => {
    const { container } = render(CornerSquare, {
      props: {
        position: 'bottom-right',
        size: 'lg'
      }
    });

    const square = container.querySelector('div');
    expect(square?.className).toContain('w-corner-lg');
    expect(square?.className).toContain('h-corner-lg');
    expect(square?.className).toContain('bottom-0');
    expect(square?.className).toContain('right-0');
  });
});
