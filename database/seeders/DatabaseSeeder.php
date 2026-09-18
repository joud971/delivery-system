<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\District;
use App\Models\Driver;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $roles = ['Admin', 'Manager', 'Employee', 'Driver'];
        foreach ($roles as $role) Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);

        $accounts = [
            ['name'=>'مدير النظام','username'=>'admin','email'=>'admin@alkhawaja.test','phone'=>'963000000001','role'=>'Admin'],
            ['name'=>'مدير العمليات','username'=>'manager','email'=>'manager@alkhawaja.test','phone'=>'963000000002','role'=>'Manager'],
            ['name'=>'موظف الطلبات','username'=>'employee','email'=>'employee@alkhawaja.test','phone'=>'963000000003','role'=>'Employee'],
            ['name'=>'سائق تجريبي','username'=>'driver','email'=>'driver@alkhawaja.test','phone'=>'963000000004','role'=>'Driver'],
        ];
        foreach ($accounts as $item) {
            $user = User::updateOrCreate(['username'=>$item['username']], [
                'name'=>$item['name'], 'email'=>$item['email'], 'phone'=>$item['phone'],
                'password'=>Hash::make('password'), 'email_verified_at'=>now(),
            ]);
            $user->syncRoles([$item['role']]);
        }

        $districts = [
            ['name'=>'وسط المدينة','city'=>'اللاذقية','delivery_fee'=>15000],
            ['name'=>'مشروع الزراعة','city'=>'اللاذقية','delivery_fee'=>18000],
            ['name'=>'الرمل الجنوبي','city'=>'اللاذقية','delivery_fee'=>17000],
            ['name'=>'جبلة','city'=>'ريف اللاذقية','delivery_fee'=>25000],
        ];
        foreach ($districts as $district) District::firstOrCreate(['name'=>$district['name']], $district + ['status'=>'active']);

        $driverUser = User::where('username','driver')->firstOrFail();
        $driver = Driver::updateOrCreate(['user_id'=>$driverUser->id], [
            'name'=>'سائق تجريبي','phone'=>'963000000004','license_number'=>'SY-1199',
            'vehicle_type'=>'motorcycle','vehicle_plate'=>'١٢٤-س-م','status'=>'active',
            'is_available'=>true,'rating'=>4.9,'earnings_total'=>420000,
        ]);

        $employee = User::where('username','employee')->firstOrFail();
        $district = District::first();
        $customer = Customer::updateOrCreate(['phone'=>'963912345678'], [
            'user_id'=>$employee->id,'name'=>'علي حسن','email'=>'customer@example.com',
            'address'=>'شارع النور، اللاذقية','district_id'=>$district->id,'status'=>'active','notes'=>'عميل تجريبي',
        ]);

        if (!Order::where('order_number','KWJ-DEMO-0001')->exists()) {
            $order = Order::create([
                'order_number'=>'KWJ-DEMO-0001','customer_id'=>$customer->id,'district_id'=>$district->id,'driver_id'=>$driver->id,
                'status'=>'in_transit','subtotal'=>0,'delivery_fee'=>$district->delivery_fee,'total'=>$district->delivery_fee,
                'payment_status'=>'pending','payment_method'=>'cash','assigned_by'=>$employee->id,'order_details'=>'طلب تجريبي لعرض النظام.',
                'driver_notes'=>'اتصل بالعميل قبل الوصول.','priority'=>'normal','customer_name_snapshot'=>$customer->name,
                'customer_phone_snapshot'=>$customer->phone,'address_snapshot'=>$customer->address,
            ]);
            $order->statusHistory()->create(['status_to'=>'in_transit','changed_by_user_id'=>$employee->id,'note'=>'بيانات تجريبية أولية.']);
        }

        Setting::updateOrCreate(['key'=>'company_name'], ['value'=>'الخواجة | Al Khawaja Delivery','group'=>'general','is_public'=>true]);
        Setting::updateOrCreate(['key'=>'default_delivery_fee'], ['value'=>'15000','group'=>'general','is_public'=>true]);
    }
}
