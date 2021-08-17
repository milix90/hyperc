<?php

namespace App\Http\Requests\Category;

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
            'name' => 'required|string|regex:/^[A-Za-z ]+$/',
            'product' => 'required|numeric',
            'web_priority' => 'required|numeric',
            'app_priority' => 'required|numeric',
            'parent' => 'required|numeric',
            'icon' => 'required|string',
            'color' => 'required|string',
            'file' => 'mimes:jpeg,jpg,png',
        ];
    }

    public function messages()
    {
        return [
            'name.regex' => 'Only string is allowed for category name!'
        ];
    }
}
