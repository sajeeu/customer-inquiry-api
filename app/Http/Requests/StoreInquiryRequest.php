<?php

namespace App\Http\Requests;

use App\Models\Inquiry;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150'],
            'category' => ['required', 'string', Rule::in(Inquiry::categories())],
            'message' => ['required', 'string', 'min:5', 'max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'category.in' => 'The selected category is invalid.',
        ];
    }
}
