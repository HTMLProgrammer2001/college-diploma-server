<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ViewProfileTest extends TestCase
{
    /**
     * Test get user info as unauthorized user
     */
    public function testUnauthorized()
    {
        $response = $this->getJson  ('/api/users/1');
        $response->assertUnauthorized();
    }

    /**
     * Test get info with role User
     */
    public function testSmallRole()
    {
        /**
         * @var User $user
         */
        $user = User::query()->where('role', '50')->first()->getModel();
        Passport::actingAs($user);

        $response = $this->getJson('/api/users/1');
        $response->assertForbidden();
    }

    /**
     * Test get info with role Moderator or higher
     */
    public function testSuccess()
    {
        /**
         * @var User $user
         */
        $user = User::query()->where('role', '<=', 30)->first();
        Passport::actingAs($user);

        $response = $this->getJson('/api/users/2');
        $response->assertSuccessful();
    }
}
