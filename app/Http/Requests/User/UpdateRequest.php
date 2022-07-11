<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'email' => 'required|unique:admin|regex:/(.+)@(.+)\.(.+)/i|string|max:100',
            'user_name' => 'required|unique:admin',
            'password' => 'required',
            'fist_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'birthday' => 'required|date|before: -18 year',
            'password_confirm' => 'required|same:password',
            'image' => 'required|image|mimes:jpeg,png,jpg,|max:3048',
            'address' => 'required',
            'province_id'=>'required',
            'district_id'=>'required',
            'commune_id'=>'required',
        ];
    }
}
