<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public const STATUSES = [
        'new' => 'جديد',
        'confirmed' => 'تم القبول',
        'assigned' => 'تم إسناده',
        'in_transit' => 'قيد التوصيل',
        'delivered' => 'تم التسليم',
        'failed' => 'فشل التسليم',
        'cancelled' => 'ملغي',
    ];

    public const PAYMENT_STATUSES = [
        'pending' => 'معلّق',
        'paid' => 'مدفوع',
        'failed' => 'فشل',
        'refunded' => 'مسترد',
    ];

    public const PAYMENT_METHODS = [
        'cash' => 'نقدي',
        'transfer' => 'تحويل',
    ];

    public const PRIORITIES = [
        'normal' => 'عادي',
        'urgent' => 'مستعجل',
    ];

    protected $fillable = [
        'order_number', 'customer_id', 'district_id', 'driver_id', 'status',
        'subtotal', 'delivery_fee', 'total', 'payment_status', 'assigned_by',
        'order_details', 'driver_notes', 'priority', 'payment_method',
        'expected_delivery_at', 'customer_name_snapshot', 'customer_phone_snapshot',
        'address_snapshot', 'notes', 'delivered_at',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'delivery_fee' => 'decimal:2',
            'total' => 'decimal:2',
            'expected_delivery_at' => 'datetime',
            'delivered_at' => 'datetime',
        ];
    }

    public function customer() { return $this->belongsTo(Customer::class); }
    public function district() { return $this->belongsTo(District::class); }
    public function driver() { return $this->belongsTo(Driver::class); }
    public function assignedBy() { return $this->belongsTo(User::class, 'assigned_by'); }
    public function statusHistory() { return $this->hasMany(OrderStatusHistory::class); }
    public function payments() { return $this->hasMany(Payment::class); }

    public function statusLabel(): string { return self::STATUSES[$this->status] ?? $this->status; }
    public function paymentStatusLabel(): string { return self::PAYMENT_STATUSES[$this->payment_status] ?? $this->payment_status; }
    public function paymentMethodLabel(): string { return self::PAYMENT_METHODS[$this->payment_method] ?? $this->payment_method; }
    public function priorityLabel(): string { return self::PRIORITIES[$this->priority] ?? $this->priority; }

    public function remainingAmount(): float
    {
        return max(0, (float) $this->delivery_fee - (float) $this->payments()->where('status', 'paid')->sum('amount'));
    }
}
