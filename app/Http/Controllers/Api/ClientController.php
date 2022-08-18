<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ClientRequest;
use App\Services\Client\ClientService;

class ClientController extends Controller
{
    public $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function show($id)
    {
        return $this->clientService->show($id);
    }
    
    public function store(ClientRequest $request)
    {
        return $this->clientService->store($request);
    }
    
    public function index()
    {
        return $this->clientService->index();
    }
}
