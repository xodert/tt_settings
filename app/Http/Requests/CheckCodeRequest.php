<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CheckCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function prepareForValidation(): void {}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'confirmation_type' => ['required', 'string', 'exists:confirmation_types,alias'],
            'source' => ['required', 'string', 'exists:sources,alias'],
            'action' => ['required', 'string'],
            'code' => ['required', 'numeric', 'min:0', 'min_digits:4', 'max_digits:4'],
        ];
    }
}
