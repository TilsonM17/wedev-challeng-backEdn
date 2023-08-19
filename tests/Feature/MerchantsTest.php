<?php

namespace Tests\Feature;

use App\Models\Merchant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MerchantsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->actingAs(User::first());
    }

    /**
     * A basic feature test example.
     */
    public function test_merchant_index_should_return_data(): void
    {
        $response = $this->get('/api/merchants');

        $response->assertStatus(200);
        $response->assertJsonIsArray('data');
    }

    public function test_it_can_create_a_merchant()
    {
        $merchant = User::inRandomOrder()->firstWhere(['is_admin' => true]);

        $data = [
            'merchant_name' => 'Merchant' . $merchant->full_name,
            'is_admin' => $merchant->is_admin,
            'admin_id' => $merchant->id
        ];
        $this->post('/api/merchants', $data);

        unset($data['is_admin']);
        $this->assertDatabaseHas('merchants', $data);
    }

    public function test_it_can_retrieve_a_merchant()
    {
        $merchant = User::inRandomOrder()->first();
        $response = $this->get('/api/merchants/' . $merchant->id);
        $response->assertOk();
    }

    public function test_it_can_update_a_merchant()
    {
        $random = User::inRandomOrder()->whereHas('merchant')->with('merchant')->firstWhere(['is_admin' => true]);

        $data = [
            'merchant_name' => 'Merchant' . $random->merchant->merchant_name,
        ];
        $this->putJson('/api/merchants/' . $random->merchant->id, $data);

        $this->assertDatabaseHas('merchants', $data);
    }
}
