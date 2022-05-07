<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $profile = auth()->user();

        return [
            'nip' => ['nullable', 'numeric', Rule::unique('users', 'nip')->ignore($profile->id)],
            'group' => ['nullable', 'string'],
            'position' => ['required', 'string'],
            'name' => ['required', 'string'],
            'contact' => ['required', 'numeric', Rule::unique('users', 'contact')->ignore($profile->id)],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($profile->id)],
        ];
    }
}
