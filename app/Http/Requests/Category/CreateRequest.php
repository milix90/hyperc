<?php

namespace App\Http\Requests\Category;

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
            'name' => 'required|string|regex:/^[A-Za-z ]+$/',
            'product' => 'required|numeric',
            'parent' => 'nullable|numeric',
            'icon' => 'required|string',
            'color' => 'required|string',
            'file' => 'required|mimes:jpeg,jpg,png',
        ];
    }

    public function messages()
    {
        return [
            'name.regex' => 'Only string is allowed for category name!'
        ];
    }
}
