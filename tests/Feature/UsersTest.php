<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;

class UsersTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /** @test */
    public function a_auth_can_create_users()
    {
        $this->withoutExceptionHandling();
        $attribues = [
            'name' => $this->faker->name,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'role' => 'user',
            'age' => $this->faker->numberBetween(10, 80),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
        Passport::actingAs(factory(\App\User::class)->create(['role' => 'admin']));
        $this->post('/api/user', $attribues);
        $this->assertDatabaseHas('users', $attribues);
    }
}
