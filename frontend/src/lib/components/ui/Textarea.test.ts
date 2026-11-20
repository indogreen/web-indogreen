import { describe, it, expect } from 'vitest';
import { render, screen, fireEvent } from '@testing-library/svelte';
import Textarea from './Textarea.svelte';

describe('Textarea Component', () => {
  it('renders label and textarea with min-height', () => {
    render(Textarea, {
      props: {
        label: 'Deskripsi Kebutuhan',
        placeholder: 'Tuliskan detail proyek...'
      }
    });

    const textarea = screen.getByLabelText('Deskripsi Kebutuhan');
    expect(textarea).toBeInTheDocument();
    expect(textarea.className).toContain('min-h-textarea-min');
    expect(textarea.className).toContain('rounded-sm');
  });

  it('renders error state correctly', () => {
    render(Textarea, {
      props: {
        id: 'pesan-textarea',
        label: 'Pesan',
        error: 'Pesan wajib diisi minimal 20 karakter'
      }
    });

    const textarea = screen.getByLabelText('Pesan');
    expect(textarea).toHaveAttribute('aria-invalid', 'true');
    expect(textarea).toHaveAttribute('aria-describedby', 'pesan-textarea-error');
    expect(screen.getByRole('alert')).toHaveTextContent('Pesan wajib diisi minimal 20 karakter');
    expect(textarea.className).toContain('border-error');
  });

  it('handles disabled state', () => {
    render(Textarea, {
      props: {
        label: 'Catatan Kunci',
        disabled: true
      }
    });

    const textarea = screen.getByLabelText('Catatan Kunci');
    expect(textarea).toBeDisabled();
    expect(textarea.className).toContain('cursor-not-allowed');
  });

  it('updates value on change', async () => {
    render(Textarea, {
      props: {
        label: 'Input Pesan',
        value: ''
      }
    });

    const textarea = screen.getByLabelText<HTMLTextAreaElement>('Input Pesan');
    await fireEvent.input(textarea, { target: { value: 'Spesifikasi panel surya 100Wp' } });
    expect(textarea.value).toBe('Spesifikasi panel surya 100Wp');
  });
});
