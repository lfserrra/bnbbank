<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthenticationTest extends TestCase {

    public function test_must_enter_username_and_password()
    {
        $this->json('POST', 'auth/login')
             ->assertStatus(422)
             ->assertJson([
                 'message' => 'The username field is required. (and 1 more error)',
                 'errors'  => [
                     "username" => ['The username field is required.'],
                     "password" => ['The password field is required.'],
                 ]
             ]);
    }

    public function test_must_wrong_username_or_password()
    {
        $loginData = ['username' => 'user', 'password' => 'user'];

        $this->json('POST', 'auth/login', $loginData)
             ->assertStatus(422)
             ->assertJson([
                 'message' => 'These credentials do not match our records.',
                 'errors'  => [
                     'username' => ['These credentials do not match our records.'],
                 ]
             ]);
    }

    public function test_must_successful_login()
    {
        $user = \Turnover\Models\User\User::factory()->create();

        $loginData = ['username' => $user->username, 'password' => $user->username];

        $this->json('POST', 'auth/login', $loginData)
             ->assertStatus(200)
             ->assertJsonPath('success', true)
             ->assertJsonPath('user.username', $user->username)
             ->assertJsonStructure(['success', 'user', 'token']);
    }

    public function test_must_logout_fail()
    {
        $this->json('POST', 'auth/logout')
             ->assertStatus(401)
             ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function test_must_successful_logout()
    {
        $user = \Turnover\Models\User\User::factory()->create();

        Sanctum::actingAs($user, ['*']);

        $this->json('POST', 'auth/logout')
             ->assertStatus(200)
             ->assertJson(['success' => true]);
    }

    public function test_must_successful_logout_with_token()
    {
        $user  = \Turnover\Models\User\User::factory()->create();
        $token = $user->createToken('authtoken');

        $this->assertEquals(1, $user->tokens()->count());

        $this->withHeaders(['Authorization' => "Bearer $token->plainTextToken"])
             ->json('POST', 'auth/logout')
             ->assertStatus(200)
             ->assertJson(['success' => true]);

        $this->assertEquals(0, $user->tokens()->count());
    }
}
