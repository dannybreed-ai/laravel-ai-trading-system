<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepositRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:0.01'],
            'network' => ['required', 'string', 'in:BTC,ETH,USDT-TRC20,USDT-ERC20,BNB'],
            'transaction_hash' => ['nullable', 'string', 'max:255'],
            'wallet_address' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'Deposit amount is required.',
            'amount.numeric' => 'Deposit amount must be a valid number.',
            'amount.min' => 'Deposit amount must be at least 0.01.',
            'network.required' => 'Please select a network.',
            'network.in' => 'Invalid network selected.',
        ];
    }
}
