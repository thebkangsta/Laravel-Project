<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegisterRequest extends Request
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
            'name' => 'required|between:1,255|alpha_spaces',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6|different:email,name',
            'confirmpassword' => 'required|same:password',
        ];
    }
}