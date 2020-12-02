<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ReportTest extends TestCase
{
    public function testUser()
    {
        $user = User::query()->where('role', 50)->first();
        Passport::actingAs($user);

        $response = $this->get('/api/report');
        $response->assertForbidden();
    }

    public function testMoreRole()
    {
        $user = User::query()->where('role', '<=', 30)->first();
        Passport::actingAs($user);

        $response = $this->get('/api/report');
        $response->assertSuccessful();
    }
}
