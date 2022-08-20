<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Stock;
use App\Models\Client;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    public function testPurchaseStore()
    {
        $token = $this->login();
       $this->post('/api/v1/stock',[
            'company_name' => 'test',
            'price' => 5.6
        ], ['HTTP_Authorization' => 'Bearer: ' . $token]);

        $this->post('/api/v1/client',[
            'username' => 'test'
        ], ['HTTP_Authorization' => 'Bearer: ' . $token]);

        $stock = Stock::first();
        $client = Client::first();

        $resp = $this->post('/api/v1/purchase',[
            'stock' => $stock->id,
            'client' => $client->id,
            'volume' => 100
        ], ['HTTP_Authorization' => 'Bearer: ' . $token]);
        $result = Purchase::all();

        $this->assertCount(1, $result);
        $resp->assertStatus(201);
    }

    public function testPurchaseList()
    {
        $token = $this->login();
        $resp = $this->get('/api/v1/purchase', ['HTTP_Authorization' => 'Bearer: ' . $token]);
        $resp->assertStatus(200);
    }
}
