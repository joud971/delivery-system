<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('order_details')->nullable()->after('total');
            $table->text('driver_notes')->nullable()->after('order_details');
            $table->string('priority')->default('normal')->after('driver_notes');
            $table->string('payment_method')->default('cash')->after('payment_status');
            $table->timestamp('expected_delivery_at')->nullable()->after('payment_method');
            $table->string('customer_name_snapshot')->nullable()->after('expected_delivery_at');
            $table->string('customer_phone_snapshot')->nullable()->after('customer_name_snapshot');
            $table->text('address_snapshot')->nullable()->after('customer_phone_snapshot');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'order_details', 'driver_notes', 'priority', 'payment_method',
                'expected_delivery_at', 'customer_name_snapshot', 'customer_phone_snapshot', 'address_snapshot',
            ]);
        });
    }
};
