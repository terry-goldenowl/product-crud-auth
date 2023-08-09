<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     */

    public function test_register_user(): void
    {
        $response = $this->post('/register', [
            'name' => 'thinhnh',
            'email' => fake()->email(),
            // 'email' => 'thienlv@gmail.com',
            'password' => '18122002',
            'password_confirmation' => '18122002',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    public function test_login_user(): void
    {
        $response = $this->post('/login', [
            'email' => 'thinhnh@gmail.com',
            'password' => '18122002',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    public function test_delete_user(): void
    {
        $user = User::where('email', 'thienlv@gmail.com')->first();
        $this->actingAs($user);

        $randomId = random_int(0, 100);
        $response = $this->delete('/users/' . $randomId);

        $response->assertStatus(302);
        $response->assertSessionHas('success');
    }
}
