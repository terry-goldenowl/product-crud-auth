<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use DatabaseTransactions;

    public function test_create_product()
    {
        $user = User::where('email', 'thienlv@gmail.com')->first();
        $this->actingAs($user);

        $productData = [
            'name' => fake()->word(),
            'description' => fake()->text(),
            'price' => fake()->numberBetween(0, 100000),
            'image' => fake()->imageUrl()
        ];

        $response = $this->post(route('products.create', $productData));

        $response->assertStatus(302);
        $response->assertSessionHas('success');
    }

    public function test_update_product()
    {
        $user = User::where('email', 'thienlv@gmail.com')->first();
        $this->actingAs($user);

        $response = $this->patch(route('products.update', ['id' => 2]), [
            'name' => fake()->word(),
            'description' => fake()->text(),
            'price' => fake()->numberBetween(0, 100000),
            'image' => fake()->imageUrl()
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');
    }

    public function test_delete_product()
    {
        $user = User::where('email', 'thienlv@gmail.com')->first();
        $this->actingAs($user);

        $response = $this->delete(route('products.delete', ["id" => 5]));

        $response->assertStatus(302);
        $response->assertSessionHas('success');
    }
}
