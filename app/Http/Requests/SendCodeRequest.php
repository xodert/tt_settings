<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendCodeRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'confirmation_type' => ['required', 'string', 'exists:confirmation_types,alias'],
            'source' => ['required', 'string', 'exists:sources,alias'],
            'action' => ['required', 'string'],
            'action_data' => ['required', 'array'],
        ];
    }
}
