<?php

namespace App\Http\Requests\Product;

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
            'sku' => 'required|min:10|max:20|regex:/^[a-zA-Z0-9]+$/',
            'name' => 'required|string|max:255',
            'stock' => 'required|alpha_num|min:0|max:1000',
            'expired_at' => 'nullable|date|after:tomorrow',
            'flag_delete' => 'boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,|max:3048',
        ];
    }
}
