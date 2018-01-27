<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'txtUser' => 'required|string|max:255|unique:users,username',
            'txtEmail' => 'required|string|email|max:255|unique:users,email',
            'txtPass' => 'required|min:3',
            'txtRePass' => 'required|min:3|same:txtPass'
        ];
    }
    public function messages() {
        return [
            'txtUser.required' => 'Please enter your username!',
            'txtUser.max' => 'username need less than 255 character',
            'txtUser.unique' => 'username is exists',
            'txtEmail.required' => 'Please enter your email',
            'txtEmail.email' => 'Your email is error syntax',
            'txtPass.required' => 'Please enter password',
            'txtPass.min' => 'Your password need more than 6 character',
            'txtRePass.required' => 'Please enter re-pass',
            'txtRePass.same' => 'Two Pass don\'t match'
        ];
    }
}
