<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingUpdateRequest extends FormRequest
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
            'value' => ['required']
        ];
    }
}
