<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'license_number',
        'vehicle_type',
        'vehicle_plate',
        'status',
        'is_available',
        'rating',
        'earnings_total',
    ];

    protected function casts(): array
    {
        return ['is_available' => 'boolean', 'rating' => 'decimal:2', 'earnings_total' => 'decimal:2'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function workSessions()
    {
        return $this->hasMany(DriverWorkSession::class);
    }

    public function locations()
    {
        return $this->hasMany(DriverLocation::class);
    }
}
