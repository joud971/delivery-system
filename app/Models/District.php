<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = [
        'name',
        'city',
        'delivery_fee',
        'status',
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
