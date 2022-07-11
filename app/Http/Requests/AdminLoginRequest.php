<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'password' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'Email không để trống',
            'email.regex' => 'Email không đúng định dạng',
            'password.required' => 'Password không để trống',
        ];
    }
}
