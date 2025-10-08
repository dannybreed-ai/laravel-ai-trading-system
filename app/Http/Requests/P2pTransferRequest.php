<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class P2pTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'receiver_username' => ['required', 'string'],
            'amount' => ['required', 'numeric', 'min:0.01', 'max:100000'],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.min' => 'Minimum transfer amount is $0.01',
        ];
    }
}
