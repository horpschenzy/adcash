<?php

namespace App\Services\Misc;

use App\Models\Stock;
use App\Models\Client;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MiscService
{
    /**
     * List the available Dashboard stats.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $stocks = Stock::orderBy('price', 'DESC')->limit(5)->get();
        $clients = Client::with('purchases')->limit(5)->get();
        
        $stockCount = Stock::count();
        $clientCount = Client::count();
        $purchaseCount = Purchase::count();

        $data = [
            'stats' => [
                'stocks' => $stockCount,
                'clients' => $clientCount,
                'purchases' => $purchaseCount,
            ],
            'tableData' => [
                'stocks' => $stocks,
                'clients' => $clients
            ]
        ];

        return response()->json(
            [
                'status' => true,
                'message' => 'Fetched Successfully',
                'data' => $data
            ], 
            200
        );
    }
}
