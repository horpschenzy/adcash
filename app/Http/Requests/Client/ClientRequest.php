<?php

namespace App\Http\Requests\Client;

use App\Http\Requests\APIRequest;

class ClientRequest extends APIRequest
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
            'username' => 'required|max:255|string|unique:clients,username'
        ];
    }
}
