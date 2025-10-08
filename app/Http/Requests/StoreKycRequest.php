<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKycRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'document_type' => ['required', 'string', 'in:passport,id_card,drivers_license'],
            'document_number' => ['required', 'string', 'max:100'],
            'document_front' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
            'document_back' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
            'selfie' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:4096'],
        ];
    }

    public function messages(): array
    {
        return [
            'document_type.required' => 'Document type is required.',
            'document_type.in' => 'Invalid document type selected.',
            'document_number.required' => 'Document number is required.',
            'document_front.required' => 'Front of document is required.',
            'document_front.mimes' => 'Document must be a valid image (jpg, jpeg, png, pdf).',
            'document_front.max' => 'Document file size must not exceed 4MB.',
            'selfie.required' => 'Selfie with document is required.',
            'selfie.mimes' => 'Selfie must be a valid image (jpg, jpeg, png).',
            'selfie.max' => 'Selfie file size must not exceed 4MB.',
        ];
    }
}
