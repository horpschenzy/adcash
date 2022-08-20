<?php

namespace App\Services\Stock;

use App\Models\Stock;
use App\Models\Client;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PurchaseService
{
    /**
     * Save the client's purchased stock.
     *
     * @param  object $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($request)
    {
        DB::beginTransaction();
        try {
            $stock = Stock::find($request->stock);
            $client = Client::find($request->client);
            $volume = $request->volume;
            $price = round($volume * $stock->price, 2);

            if ($price > $client->balance) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Client balance is low. Kindly fund and try again'
                    ], 
                    400
                );
            }
            $newBalance = $client->balance - $price;
            $purchase = new Purchase();
            $purchase->stock_id = $request->stock;
            $purchase->client_id = $request->client;
            $purchase->volume = $volume;
            $purchase->price = $price;
            if (!$purchase->save()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Stock cannot be pruchased at this time. Please try again'
                    ], 
                    400
                );
            }
            $client->balance = $newBalance;
            $client->save();
            DB::commit();
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Stock purchased successfully',
                    'data' => []
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
     * List the available purchased stocks.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $stocks = Purchase::with('stock')->with('client')->orderBy('price', 'DESC')->get();

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
