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
    public function a_auth_user_can_see_his_information()
    {
        $this->withoutExceptionHandling();
        Passport::actingAs(factory(\App\User::class)->create(['role' => 'admin']));
        $this->get('/api/user')->assertJsonStructure();
    }
}
