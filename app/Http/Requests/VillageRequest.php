<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VillageRequest extends FormRequest
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
        if (request()->isMethod('put')) {
            $email = 'unique:villages,email,' . $this->id;
            $phone = 'unique:villages,phone,' . $this->id;
        }
        
        if (request()->isMethod('post')) {
            $email = 'unique:villages,email';
            $phone = 'unique:villages,phone';
        }

        return [
            'village' => ['required', 'string'],
            'email' => ['nullable', 'email', 'min:2', $email],
            'phone' => ['nullable', 'numeric', 'min:2', $phone],
            'rw' => ['nullable', 'numeric'],
            'rt' => ['nullable', 'numeric'],
            'head_village' => ['nullable', 'string', 'min:2'],
        ];
    }
}
