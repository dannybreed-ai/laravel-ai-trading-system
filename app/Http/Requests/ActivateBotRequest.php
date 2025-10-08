<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivateBotRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'bot_id' => ['required', 'exists:bots,id'],
            'investment_amount' => ['required', 'numeric', 'min:0.01'],
        ];
    }

    public function messages(): array
    {
        return [
            'bot_id.required' => 'Please select a bot to activate.',
            'bot_id.exists' => 'The selected bot does not exist.',
            'investment_amount.required' => 'Investment amount is required.',
            'investment_amount.numeric' => 'Investment amount must be a valid number.',
            'investment_amount.min' => 'Investment amount must be at least 0.01.',
        ];
    }
}
