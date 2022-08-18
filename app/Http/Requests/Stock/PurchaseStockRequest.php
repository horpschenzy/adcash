<?php

namespace App\Http\Requests\Stock;

use App\Http\Requests\APIRequest;

class PurchaseStockRequest extends APIRequest
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
            'stock' => 'required|integer|exists:App\Models\Stock,id',
            'client' => 'required|integer|exists:App\Models\Client,id',
            'volume' => 'required|integer|min:1'
        ];
    }
}
