<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DriverApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_driver_can_login_and_receive_sanctum_token(): void
    {
        $driverRole = Role::create(['name' => 'Driver', 'guard_name' => 'web']);
        $driver = User::factory()->create(['email' => 'driver-api@example.com', 'password' => bcrypt('password')]);
        $driver->assignRole($driverRole);

        $response = $this->postJson('/api/v1/driver/login', [
            'email' => 'driver-api@example.com',
            'password' => 'password',
        ]);

        $response->assertOk()->assertJsonStructure(['token', 'user']);
        $this->assertDatabaseCount('personal_access_tokens', 1);
    }
}
