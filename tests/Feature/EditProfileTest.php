<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;
use Mockery\Generator\StringManipulation\Pass\Pass;
use Tests\TestCase;

class EditProfileTest extends TestCase
{
    /**
     * Success test
     */

    public function testSuccess()
    {
        $user = User::query()->first();
        Passport::actingAs($user);

        $user = User::query()->first();

        $data = [
            'email' => $user->email,
            'address' => 'Test address'
        ];

        $response = $this->postJson('/api/editMe', $data);

        $response->assertSuccessful();
        $this->assertArrayHasKey( 'newUser', $response);
        //$this->assertEquals($response['newUser']['address'], 'Test address');
    }

    /**
     * Test with empty data
     */
    public function emptyTest()
    {
        $user = User::query()->first();
        Passport::actingAs($user);

        $response = $this->postJson('/api/editMe', []);

        $response->assertJsonValidationErrors(['email']);
        $this->assertEquals($response['errors']['email'][0], "The email field is required.");
    }

    /**
     * Test with invalid data
     */
    public function testInvalid()
    {
        $user = User::query()->first();
        Passport::actingAs($user);

        $data = [
            'email' => 'bademail'
        ];

        $response = $this->postJson('/api/editMe', $data);

        $response->assertJsonValidationErrors(['email']);
        $this->assertEquals($response['errors']['email'][0], "The email must be a valid email address.");
    }

    /**
     * Test without user
     */
    public function testUnauthorized()
    {
        $response = $this->postJson('/api/editMe', [
            'email' => 'test@gmail.com'
        ]);

        $response->assertUnauthorized();
    }
}
