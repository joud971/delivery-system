<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function store(Request $request, Order $order)
    {
        abort_unless(auth()->user()->can('manage-finances'), 403);
        $data = $request->validate(['amount' => 'required|numeric|min:0.01', 'method' => 'required|in:cash,transfer', 'reference_no' => 'nullable|string|max:100']);
        abort_if($data['amount'] > ($order->delivery_fee - $order->payments()->where('status', 'paid')->sum('amount')), 422, 'قيمة الدفعة تتجاوز المتبقي من أجرة التوصيل.');

        DB::transaction(function () use ($order, $data) {
            Payment::create($data + ['order_id' => $order->id, 'status' => 'paid', 'paid_at' => now()]);
            if ($order->payments()->where('status', 'paid')->sum('amount') >= $order->delivery_fee) {
                $order->update(['payment_status' => 'paid']);
            }
        });

        return back()->with('success', 'تم تسجيل الدفعة');
    }
}
