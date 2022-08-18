<?php

namespace App\Services\Client;

use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientService
{
    /**
     * Show the Selected client.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $client = Client::with('purchases')->where('id', $id)->first();

        return response()->json(
            [
                'status' => true,
                'message' => 'Fetched Successfully',
                'data' => $client
            ], 
            200
        );
    }
    
    /**
     * Save the client username.
     *
     * @param  object $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($request)
    {
        DB::beginTransaction();
        try {
            $client = new Client();
            $client->username = $request->username;
            $client->balance = 1000;
            if (! $client->save()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Client cannot be added at this time. Please try again'
                    ], 
                    400
                );
            }
            DB::commit();
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Client added successfully',
                    'data' => $client
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
     * List the available clients.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $clients = Client::with('purchases')->get();

        return response()->json(
            [
                'status' => true,
                'message' => 'Fetched Successfully',
                'data' => $clients
            ], 
            200
        );
    }
    
}
