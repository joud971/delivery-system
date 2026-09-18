<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverLocation extends Model
{
    protected $fillable = [
        'driver_id',
        'latitude',
        'longitude',
        'accuracy',
        'recorded_at',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'accuracy' => 'decimal:2',
            'recorded_at' => 'datetime',
        ];
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}