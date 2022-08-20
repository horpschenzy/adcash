<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Stock;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StockTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    public function testStockStore()
    {
        $token = $this->login();
        $resp = $this->post('/api/v1/stock',[
            'company_name' => 'test',
            'price' => 5.6
        ], ['HTTP_Authorization' => 'Bearer: ' . $token]);
        
        $result = Stock::all();
        $this->assertCount(1, $result);
        $resp->assertStatus(201);
    }
    
    public function testStockUpdate()
    {
        $token = $this->login();
        $this->post('/api/v1/stock',[
            'company_name' => 'test',
            'price' => 5.6
        ], ['HTTP_Authorization' => 'Bearer: ' . $token]);
        $stock = Stock::first();

        $newresp = $this->put('/api/v1/stock',[
            'stock' => $stock->id,
            'price' => 6
        ], ['HTTP_Authorization' => 'Bearer: ' . $token]);
        
        $stock->refresh();

        $this->assertEquals('6', $stock->price);
        $newresp->assertStatus(201);
    }

    public function testStockList()
    {
        $token = $this->login();
        $resp = $this->get('/api/v1/stock', ['HTTP_Authorization' => 'Bearer: ' . $token]);
        $resp->assertStatus(200);
    }

    public function testStockDelete()
    {
        $token = $this->login();
        $resp = $this->post('/api/v1/stock',[
            'company_name' => 'test',
            'price' => 5.6
        ], ['HTTP_Authorization' => 'Bearer: ' . $token]);
        $stock = Stock::first();

        $newresp = $this->delete('/api/v1/stock',[
            'stock' => $stock->id
        ], ['HTTP_Authorization' => 'Bearer: ' . $token]);
        
        $this->assertDatabaseCount('stocks', 0);
        $newresp->assertStatus(201);
    }
    
}
