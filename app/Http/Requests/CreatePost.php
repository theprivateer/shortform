<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePost extends FormRequest
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
            'markdown'  => 'required_without:images'
        ];
    }

    public function messages()
    {
        return [
          'markdown.required_without' => 'Either enter text or upload an image'
        ];
    }
}
