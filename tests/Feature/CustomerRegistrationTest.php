<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerRegistrationTest extends TestCase {

    public function test_must_enter_with_required_fields()
    {
        $this->json('POST', 'auth/register')
             ->assertStatus(422)
             ->assertJson([
                 'message' => 'The name field is required. (and 4 more errors)',
                 'errors'  => [
                     'name'                  => ['The name field is required.'],
                     'email'                 => ['The email field is required.'],
                     'username'              => ['The username field is required.'],
                     'password'              => ['The password field is required.'],
                     'password_confirmation' => ['The password confirmation field is required.'],
                 ]
             ]);
    }

    public function test_must_fail_with_wrong_email_format()
    {
        $data = [
            'name'                  => 'User',
            'email'                 => 'user@',
            'username'              => 'user',
            'password'              => 'user',
            'password_confirmation' => 'user'
        ];

        $this->json('POST', 'auth/register', $data)
             ->assertStatus(422)
             ->assertJson([
                 'message' => 'The email must be a valid email address.',
                 'errors'  => [
                     'email' => ['The email must be a valid email address.'],
                 ]
             ]);
    }

    public function test_must_fail_with_username_or_email_exists_in_database()
    {
        $user = \Turnover\Models\User\User::factory()->create([
            'email'    => 'user@user.com',
            'username' => 'user',
        ]);

        $data = [
            'name'                  => 'User',
            'email'                 => 'user@user.com',
            'username'              => 'user',
            'password'              => 'user',
            'password_confirmation' => 'user'
        ];

        $this->json('POST', 'auth/register', $data)
             ->assertStatus(422)
             ->assertJson([
                 'message' => 'The email has already been taken. (and 1 more error)',
                 'errors'  => [
                     'email'    => ['The email has already been taken.'],
                     'username' => ['The username has already been taken.'],
                 ]
             ]);
    }

    public function test_must_fail_with_wrong_password_confirmation()
    {
        $data = [
            'name'                  => 'User',
            'email'                 => 'user@user.com',
            'username'              => 'user',
            'password'              => 'user',
            'password_confirmation' => 'user1'
        ];

        $this->json('POST', 'auth/register', $data)
             ->assertStatus(422)
             ->assertJson([
                 'message' => 'The password confirmation does not match.',
                 'errors'  => [
                     'password' => ['The password confirmation does not match.'],
                 ]
             ]);
    }

    public function test_must_successful_registration()
    {
        $data = [
            'name'                  => 'User',
            'email'                 => 'user@user.com',
            'username'              => 'user',
            'password'              => 'user',
            'password_confirmation' => 'user'
        ];

        $this->json('POST', 'auth/register', $data)
             ->assertStatus(200)
             ->assertJsonPath('success', true)
             ->assertJsonPath('user.username', 'user');
    }
}
