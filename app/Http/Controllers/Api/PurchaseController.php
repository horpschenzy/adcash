<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Stock\PurchaseService;
use App\Http\Requests\Stock\PurchaseStockRequest;

class PurchaseController extends Controller
{
    public $purchaseService;

    public function __construct(PurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;
    }

    public function store(PurchaseStockRequest $request)
    {
        return $this->purchaseService->store($request);
    }
    
    public function index()
    {
        return $this->purchaseService->index();
    }
}
