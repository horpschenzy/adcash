<?php

namespace App\Http\Requests\Stock;

use App\Http\Requests\APIRequest;

class StockRequest extends APIRequest
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
            'company_name' => 'required|max:255|string|unique:stocks,company_name',
            'price' => 'required|min:1'
        ];
    }
}
