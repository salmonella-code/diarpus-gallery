<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeterCRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'register_number' => ['required', 'numeric'],
            'bin' => ['nullable', 'string'],
            'name' => ['required', 'string'],
            'address' => ['required', 'string'],
        ];
    }
}
