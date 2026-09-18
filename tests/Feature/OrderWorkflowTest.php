<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\District;
use App\Models\Driver;
use App\Models\Order;
use App\Models\User;
use App\Services\OrderWorkflowService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class OrderWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_transition_records_timeline_and_notifies_driver(): void
    {
        Role::create(['name' => 'Employee', 'guard_name' => 'web']);
        $employee = User::factory()->create();
        $employee->assignRole('Employee');
        $driverUser = User::factory()->create();
        $driverRole = Role::create(['name' => 'Driver', 'guard_name' => 'web']);
        $driverUser->assignRole($driverRole);
        $driver = Driver::create(['user_id' => $driverUser->id, 'name' => 'Driver', 'phone' => '123', 'status' => 'active']);
        $district = District::create(['name' => 'Center', 'city' => 'Damascus', 'delivery_fee' => 1000]);
        $customer = Customer::create(['name' => 'Customer', 'phone' => '456', 'district_id' => $district->id]);
        $order = Order::create(['order_number' => 'KWJ-TEST-1', 'customer_id' => $customer->id, 'district_id' => $district->id, 'driver_id' => $driver->id, 'status' => 'assigned', 'subtotal' => 100, 'delivery_fee' => 10, 'total' => 110]);

        app(OrderWorkflowService::class)->transition($order, 'in_transit', $employee);

        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'in_transit']);
        $this->assertDatabaseHas('order_status_histories', ['order_id' => $order->id, 'status_to' => 'in_transit']);
        $this->assertDatabaseHas('notifications', ['user_id' => $driverUser->id, 'related_id' => $order->id]);
        $this->assertDatabaseHas('activity_logs', ['model_id' => $order->id, 'action' => 'order.status_changed']);
    }

    public function test_invalid_transition_is_rejected(): void
    {
        Role::create(['name' => 'Employee', 'guard_name' => 'web']);
        $employee = User::factory()->create();
        $employee->assignRole('Employee');
        $district = District::create(['name' => 'Center', 'city' => 'Damascus', 'delivery_fee' => 1000]);
        $customer = Customer::create(['name' => 'Customer', 'phone' => '456', 'district_id' => $district->id]);
        $order = Order::create(['order_number' => 'KWJ-TEST-2', 'customer_id' => $customer->id, 'district_id' => $district->id, 'status' => 'delivered', 'subtotal' => 100, 'delivery_fee' => 10, 'total' => 110]);

        $this->expectException(\InvalidArgumentException::class);
        app(OrderWorkflowService::class)->transition($order, 'in_transit', $employee);
    }
}
