<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_driver_cannot_open_management_orders(): void
    {
        $driver = User::factory()->create();
        Role::create(['name' => 'Driver', 'guard_name' => 'web']);
        $driver->assignRole('Driver');

        $this->actingAs($driver)->get('/orders')->assertForbidden();
    }

    public function test_employee_can_open_orders(): void
    {
        $employee = User::factory()->create();
        Role::create(['name' => 'Employee', 'guard_name' => 'web']);
        $employee->assignRole('Employee');

        $this->actingAs($employee)->get('/orders')->assertOk();
    }
}
