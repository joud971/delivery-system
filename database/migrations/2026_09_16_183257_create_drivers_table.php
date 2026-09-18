<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->unique()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('license_number')->nullable();
            $table->string('vehicle_type')->default('car');
            $table->string('vehicle_plate')->nullable();
            $table->string('status')->default('available');
            $table->boolean('is_available')->default(true);
            $table->decimal('rating', 3, 2)->default(0);
            $table->decimal('earnings_total', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
