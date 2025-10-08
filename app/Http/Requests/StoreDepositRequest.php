<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepositRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:0.01', 'max:1000000'],
            'method' => ['required', 'string', 'in:crypto,bank_transfer,card'],
            'currency' => ['required', 'string', 'in:BTC,ETH,USDT,USD'],
            'tx_hash' => ['nullable', 'string', 'max:255'],
            'wallet_address' => ['nullable', 'string', 'max:255'],
            'network' => ['nullable', 'string', 'in:BTC,ETH,TRC20,BEP20,ERC20'],
            'proof' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.min' => 'Minimum deposit amount is $0.01',
            'proof.max' => 'Proof file must not exceed 5MB',
        ];
    }
}
