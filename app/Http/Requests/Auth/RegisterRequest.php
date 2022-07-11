<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'user_name' => 'required|unique:users',
            'password' => 'required',
            'fist_name' => 'required',
            'last_name' => 'required',
            'birthday' => 'required',
            'password_confirm' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'user_name.required' => 'user_name không để trống',
            'fist_name.required' => 'fist_name không để trống',
            'last_name.required' => 'last_name không để trống',
            'email.required' => 'Email không để trống',
            'birthday.required' => 'birthday không để trống',
            'email.regex' => 'Email không đúng định dạng',
            'password.required' => 'Password không để trống',
            'password_confirm.required' => 'password_confirm không để trống',
            'password.same' => 'Password không giống',
        ];
    }
}
