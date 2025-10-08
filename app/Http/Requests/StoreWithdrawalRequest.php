<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWithdrawalRequest extends FormRequest
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
            'wallet_address' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'Withdrawal amount is required.',
            'amount.numeric' => 'Withdrawal amount must be a valid number.',
            'amount.min' => 'Withdrawal amount must be at least 0.01.',
            'network.required' => 'Please select a network.',
            'network.in' => 'Invalid network selected.',
            'wallet_address.required' => 'Wallet address is required.',
        ];
    }
}
