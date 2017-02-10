<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->id == $this->request->get('user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username'  => 'required|string|unique:users,username,' .  $this->request->get('user') . ',id',
            'email'     => 'required|email|unique:users,email,' . $this->request->get('user') . ',id',
            'password'  => 'confirmed',
        ];
    }
}
