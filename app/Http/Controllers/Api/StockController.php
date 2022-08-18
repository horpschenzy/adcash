<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Stock\StockService;
use App\Http\Requests\Stock\StockRequest;
use App\Http\Requests\Stock\DeleteStockRequest;
use App\Http\Requests\Stock\UpdateStockRequest;

class StockController extends Controller
{
    public $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function destroy(DeleteStockRequest $request)
    {
        return $this->stockService->destroy($request);
    }

    public function update(UpdateStockRequest $request)
    {
        return $this->stockService->update($request);
    }
    
    public function store(StockRequest $request)
    {
        return $this->stockService->store($request);
    }
    
    public function index()
    {
        return $this->stockService->index();
    }
}
