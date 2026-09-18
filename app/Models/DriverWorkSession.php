<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverWorkSession extends Model
{
    protected $fillable = [
        'driver_id',
        'started_at',
        'ended_at',
        'total_minutes',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
        ];
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
