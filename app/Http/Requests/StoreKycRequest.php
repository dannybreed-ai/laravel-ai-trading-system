<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKycRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'document_type' => ['required', 'string', 'in:passport,drivers_license,national_id'],
            'document_number' => ['required', 'string', 'max:100'],
            'front_image' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'back_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'selfie_image' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'front_image.max' => 'Front image must not exceed 5MB',
            'back_image.max' => 'Back image must not exceed 5MB',
            'selfie_image.max' => 'Selfie must not exceed 5MB',
        ];
    }
}
