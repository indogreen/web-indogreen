<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreInquiryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $merge = [];

        if (! $this->has('full_name') && $this->has('name')) {
            $merge['full_name'] = $this->input('name');
        }

        if (! $this->has('message_content') && $this->has('message')) {
            $merge['message_content'] = $this->input('message');
        }

        if (! $this->has('phone_whatsapp') && $this->has('phone')) {
            $merge['phone_whatsapp'] = $this->input('phone');
        }

        if (! empty($merge)) {
            $this->merge($merge);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone_whatsapp' => ['nullable', 'string', 'max:50'],
            'company_organization' => ['nullable', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message_content' => ['required', 'string', 'max:2000'],
            'product_slug' => ['nullable', 'string', 'exists:products,slug'],
            'product_id' => ['nullable', 'integer', 'exists:products,id'],
            'solution_slug' => ['nullable', 'string', 'exists:solutions,slug'],
            'solution_id' => ['nullable', 'integer', 'exists:solutions,id'],
            'consent' => ['required', 'accepted'],
            'website_url' => ['nullable', 'string', 'max:100'], // Honeypot field
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'subject.required' => 'Subjek pesan wajib diisi.',
            'message_content.required' => 'Pesan kebutuhan proyek wajib diisi.',
            'message_content.max' => 'Pesan tidak boleh melebihi 2000 karakter.',
            'consent.required' => 'Persetujuan pemrosesan data wajib dicentang.',
            'consent.accepted' => 'Persetujuan pemrosesan data wajib disetujui.',
            'product_slug.exists' => 'Produk yang dipilih tidak ditemukan.',
            'solution_slug.exists' => 'Solusi yang dipilih tidak ditemukan.',
        ];
    }
}
