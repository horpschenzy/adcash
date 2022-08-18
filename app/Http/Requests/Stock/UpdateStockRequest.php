<?php

namespace App\Http\Requests\Stock;

use App\Http\Requests\APIRequest;

class UpdateStockRequest extends APIRequest
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
            'stock' => 'required|max:255|integer|exists:App\Models\Stock,id',
            'price' => 'required|min:1'
        ];
    }
}
