<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWithdrawalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:10', 'max:1000000'],
            'method' => ['required', 'string', 'in:crypto,bank_transfer'],
            'currency' => ['required', 'string', 'in:BTC,ETH,USDT,USD'],
            'wallet_address' => ['required', 'string', 'max:255'],
            'network' => ['required', 'string', 'in:BTC,ETH,TRC20,BEP20,ERC20'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.min' => 'Minimum withdrawal amount is $10',
        ];
    }
}
