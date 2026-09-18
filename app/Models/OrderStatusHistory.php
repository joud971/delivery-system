<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    protected $fillable = [
        'order_id',
        'status_from',
        'status_to',
        'changed_by_user_id',
        'note',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
