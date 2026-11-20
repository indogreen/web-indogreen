import { describe, it, expect } from 'vitest';
import { render, screen, fireEvent } from '@testing-library/svelte';
import TextInput from './TextInput.svelte';

describe('TextInput Component', () => {
  it('renders with label and placeholder', () => {
    render(TextInput, {
      props: {
        label: 'Nama Perusahaan',
        placeholder: 'Masukkan nama PT / CV'
      }
    });

    expect(screen.getByLabelText('Nama Perusahaan')).toBeInTheDocument();
    expect(screen.getByPlaceholderText('Masukkan nama PT / CV')).toBeInTheDocument();
  });

  it('renders required indicator when required is true', () => {
    render(TextInput, {
      props: {
        label: 'Email Kantor',
        required: true
      }
    });

    const input = screen.getByLabelText(/Email Kantor/);
    expect(input).toBeRequired();
    expect(screen.getByText('*')).toBeInTheDocument();
  });

  it('renders error message and sets aria-invalid and aria-describedby', () => {
    render(TextInput, {
      props: {
        id: 'email-input',
        label: 'Alamat Email',
        error: 'Format email tidak valid'
      }
    });

    const input = screen.getByLabelText('Alamat Email');
    expect(input).toHaveAttribute('aria-invalid', 'true');
    expect(input).toHaveAttribute('aria-describedby', 'email-input-error');

    const errorMsg = screen.getByRole('alert');
    expect(errorMsg).toHaveTextContent('Format email tidak valid');
    expect(input.className).toContain('border-error');
  });

  it('renders hint text when provided and no error', () => {
    render(TextInput, {
      props: {
        id: 'telp-input',
        label: 'Nomor WhatsApp',
        hint: 'Format: 0812xxxx'
      }
    });

    const input = screen.getByLabelText('Nomor WhatsApp');
    expect(input).toHaveAttribute('aria-describedby', 'telp-input-hint');
    expect(screen.getByText('Format: 0812xxxx')).toBeInTheDocument();
  });

  it('handles disabled state', () => {
    render(TextInput, {
      props: {
        label: 'Terkunci',
        disabled: true,
        value: 'Data Terkunci'
      }
    });

    const input = screen.getByLabelText('Terkunci');
    expect(input).toBeDisabled();
    expect(input.className).toContain('cursor-not-allowed');
  });

  it('updates value on input', async () => {
    render(TextInput, {
      props: {
        label: 'Input Interaktif',
        value: ''
      }
    });

    const input = screen.getByLabelText<HTMLInputElement>('Input Interaktif');
    await fireEvent.input(input, { target: { value: 'Helios 60W' } });
    expect(input.value).toBe('Helios 60W');
  });
});
