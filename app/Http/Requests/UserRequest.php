<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        if (request()->isMethod('post')) {
            $field = ['sometimes', 'required', 'string'];
            $nip = 'unique:users,nip';
            $contact = 'unique:users,contact';
            $email = 'unique:users,email';
        }elseif (request()->isMethod('put')) {
            $field = ['sometimes', 'required', 'string'];
            $nip = Rule::unique('users', 'nip')->ignore($this->id);
            $contact = Rule::unique('users', 'contact')->ignore($this->id);
            $email = Rule::unique('users', 'email')->ignore($this->id);
        }

        if(request()->routeIs('admin.store') || request()->routeIs('admin.update') || request()->is('village-user*')){
            $field = ['sometimes', 'nullable'];
        }

        return [
            'field' => $field,
            'nip' => ['nullable', 'numeric', $nip],
            'group' => ['nullable', 'string'],
            'position'=> ['required', 'string'],
            'name' => ['required', 'string'],
            'contact' => ['required', 'numeric', $contact, 'min:10'],
            'email' => ['required', 'email', $email],
            'village' => ['sometimes', 'required', 'string']
        ];
    }
}
