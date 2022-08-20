<?php

namespace Tests\Feature;

use App\Models\Client;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ClientTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    public function testClientStore()
    {
        $token = $this->login();
        $resp = $this->post('/api/v1/client',[
            'username' => 'test'
        ], ['HTTP_Authorization' => 'Bearer: ' . $token]);
        $result = Client::all();
        $this->assertCount(1, $result);
        $resp->assertStatus(201);
    }
    
    public function testClientList()
    {
        $token = $this->login();
        $resp = $this->get('/api/v1/client', ['HTTP_Authorization' => 'Bearer: ' . $token]);
        $resp->assertStatus(200);
    }

    public function testClientShow()
    {
        $token = $this->login();
        $client = Client::make([
            'id' => 1,
            'username' => 'Test',
            'balance' => 1000
        ]);
        $id = $client->id;
        $resp = $this->get("/api/v1/client/$id/stocks", ['HTTP_Authorization' => 'Bearer: ' . $token]);
        $resp->assertStatus(200);
    }
}
