<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class P2pTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'receiver_code' => ['required', 'string', 'size:8', 'regex:/^[A-Z0-9]+$/', 'exists:users,referral_code'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'note' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'receiver_code.required' => 'Receiver referral code is required.',
            'receiver_code.size' => 'Referral code must be 8 characters.',
            'receiver_code.regex' => 'Referral code must contain only uppercase letters and numbers.',
            'receiver_code.exists' => 'The referral code does not exist.',
            'amount.required' => 'Transfer amount is required.',
            'amount.numeric' => 'Transfer amount must be a valid number.',
            'amount.min' => 'Transfer amount must be at least 0.01.',
        ];
    }
}
