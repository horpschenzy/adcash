<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\APIRequest;


class LoginRequest extends APIRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|min:8|max:255|string',
            'password' => 'required|min:8'
        ];
    }
}
