<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        $user = new User([
            'name'    => 'test',
            'email'    => 'test@email.com',
            'password' => '123456'
        ]);

        $user->save();
    }

    public function testRegisterUser()
    {
        $response = $this->post(route('register'), [
            'name'    => 'test2',
            'email'    => 'test2@email.com',
            'password' => '123456'
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in'
        ]);
    }

    public function testLogUserIn()
    {
        $response = $this->post(route('login'), [
            'email'    => 'test@email.com',
            'password' => '123456'
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in'
        ]);
    }
    public function testLogFailUserIn()
    {
        $response = $this->post(route('login'), [
            'email'    => 'test3@email.com',
            'password' => '123456'
        ]);

        $response->assertStatus(401);

        $response->assertJsonStructure([
            'error',
        ]);
    }
}
