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
            $nip = 'unique:users,nip';
            $contact = 'unique:users,contact';
            $email = 'unique:users,email';
        }elseif (request()->isMethod('put')) {
            $nip = Rule::unique('users', 'nip')->ignore($this->admin->id);
            $contact = Rule::unique('users', 'contact')->ignore($this->admin->id);
            $email = Rule::unique('users', 'email')->ignore($this->admin->id);
        }

        return [
            'nip' => ['nullable', 'numeric', $nip],
            'group' => ['nullable', 'string'],
            'position'=> ['required', 'string'],
            'name' => ['required', 'string'],
            'contact' => ['required', 'numeric', $contact, 'min:10'],
            'email' => ['required', 'email', $email],
        ];
    }
}
