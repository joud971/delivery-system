<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class OrderWorkflowService
{
    private const TRANSITIONS = [
        'new' => ['confirmed', 'assigned', 'cancelled'],
        'confirmed' => ['assigned', 'in_transit', 'cancelled'],
        'assigned' => ['confirmed', 'in_transit', 'cancelled'],
        'in_transit' => ['delivered', 'failed'],
        'failed' => ['assigned', 'cancelled'],
        'delivered' => [],
        'cancelled' => [],
    ];

    public function transition(Order $order, string $status, User $actor, ?string $note = null): Order
    {
        if (!in_array($status, self::TRANSITIONS[$order->status] ?? [], true)) {
            throw new InvalidArgumentException('لا يمكن الانتقال إلى الحالة المطلوبة من الحالة الحالية.');
        }

        return DB::transaction(function () use ($order, $status, $actor, $note) {
            $from = $order->status;
            $order->update([
                'status' => $status,
                'delivered_at' => $status === 'delivered' ? now() : $order->delivered_at,
            ]);

            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status_from' => $from,
                'status_to' => $status,
                'changed_by_user_id' => $actor->id,
                'note' => $note,
            ]);

            ActivityLog::create([
                'user_id' => $actor->id,
                'action' => 'order.status_changed',
                'model_type' => Order::class,
                'model_id' => $order->id,
                'description' => "تم تغيير حالة الطلب {$order->order_number} من ".(Order::STATUSES[$from] ?? $from)." إلى ".(Order::STATUSES[$status] ?? $status),
            ]);

            if ($order->driver?->user_id) {
                Notification::create([
                    'user_id' => $order->driver->user_id,
                    'title' => 'تحديث حالة طلب',
                    'message' => "تم تحديث الطلب {$order->order_number} إلى ".(Order::STATUSES[$status] ?? $status).'.',
                    'type' => 'order',
                    'related_model' => Order::class,
                    'related_id' => $order->id,
                ]);
            }

            return $order->fresh();
        });
    }
}
