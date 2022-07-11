<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'email' => 'required|unique:users|regex:/(.+)@(.+)\.(.+)/i|string|max:100',
            'user_name' => 'required|unique:admin',
            'password' => 'required',
            'fist_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'birthday' => 'required|date|before: -18 year',
            'password_confirm' => 'required|same:password',
            'image' => 'required|image|mimes:jpeg,png,jpg,|max:3048',
            'address' => 'required',
            'province_id' => 'required',
            'district_id' => 'required',
            'commune_id' => 'required',
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
