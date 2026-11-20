import { describe, it, expect } from 'vitest';
import { render, screen, fireEvent } from '@testing-library/svelte';
import Select from './Select.svelte';

describe('Select Component', () => {
  const sampleOptions = [
    { value: 'tio', label: 'PJU Two-In-One' },
    { value: 'aio', label: 'PJU All-In-One' },
    { value: 'shs', label: 'Solar Home System', disabled: true }
  ];

  it('renders select with options and placeholder', () => {
    render(Select, {
      props: {
        label: 'Pilihan Sistem',
        placeholder: 'Pilih sistem surya...',
        options: sampleOptions
      }
    });

    const select = screen.getByLabelText('Pilihan Sistem');
    expect(select).toBeInTheDocument();
    expect(screen.getByText('PJU Two-In-One')).toBeInTheDocument();
    expect(screen.getByText('PJU All-In-One')).toBeInTheDocument();
    expect(screen.getByText('Solar Home System')).toBeDisabled();
  });

  it('handles value selection', async () => {
    render(Select, {
      props: {
        label: 'Kategori',
        options: sampleOptions,
        value: 'tio'
      }
    });

    const select = screen.getByLabelText<HTMLSelectElement>('Kategori');
    expect(select.value).toBe('tio');

    await fireEvent.change(select, { target: { value: 'aio' } });
    expect(select.value).toBe('aio');
  });

  it('renders error state', () => {
    render(Select, {
      props: {
        id: 'sistem-select',
        label: 'Sistem',
        options: sampleOptions,
        error: 'Pilih salah satu sistem'
      }
    });

    const select = screen.getByLabelText('Sistem');
    expect(select).toHaveAttribute('aria-invalid', 'true');
    expect(screen.getByRole('alert')).toHaveTextContent('Pilih salah satu sistem');
    expect(select.className).toContain('border-error');
  });

  it('handles disabled state', () => {
    render(Select, {
      props: {
        label: 'Pilihan Terkunci',
        options: sampleOptions,
        disabled: true
      }
    });

    expect(screen.getByLabelText('Pilihan Terkunci')).toBeDisabled();
  });
});
