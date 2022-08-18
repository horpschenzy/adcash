<?php

namespace App\Services\Stock;

use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StockService
{
    /**
     * Delete the company's stock .
     *
     * @param  object $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($request)
    {
        DB::beginTransaction();
        try {
            $stock = Stock::find($request->stock);
            $stock->delete();
            DB::commit();
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Stock  deleted successfully',
                    'data' => $stock
                ], 
                201
            );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Stock price cannot be deleted at this time. Delete all related purchases and try again',
                    'data' => $e
                ], 
                500
            );
        }
    }
    
    /**
     * Update the company's stock price.
     *
     * @param  object $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($request)
    {
        DB::beginTransaction();
        try {
            $stock = Stock::find($request->stock);
            $stock->price = $request->price;
            if (!$stock->save()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Stock price cannot be updated at this time. Please try again'
                    ], 
                    400
                );
            }
            DB::commit();
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Stock price updated successfully',
                    'data' => $stock
                ], 
                201
            );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Internal server error',
                    'data' => $e
                ], 
                500
            );
        }
    }

    /**
     * Save the company's stock.
     *
     * @param  object $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($request)
    {
        DB::beginTransaction();
        try {
            $stock = new Stock();
            $stock->company_name = $request->company_name;
            $stock->price = $request->price;
            if (!$stock->save()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Stock cannot be added at this time. Please try again'
                    ], 
                    400
                );
            }
            DB::commit();
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Stock added successfully',
                    'data' => $stock
                ], 
                201
            );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Internal server error',
                    'data' => $e
                ], 
                500
            );
        }
    }

   
    /**
     * List the available stocks.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $stocks = Stock::orderBy('price', 'DESC')->get();

        return response()->json(
            [
                'status' => true,
                'message' => 'Fetched Successfully',
                'data' => $stocks
            ], 
            200
        );
    }
}
