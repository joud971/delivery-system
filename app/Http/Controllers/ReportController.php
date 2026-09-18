<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Driver;
use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->user()->hasAnyRole(['Admin', 'Manager']), 403);

        $from = $request->date('from')?->startOfDay() ?? now()->startOfMonth();
        $to = $request->date('to')?->endOfDay() ?? now()->endOfDay();
        $base = Order::whereBetween('created_at', [$from, $to]);
        $totalOrders = (clone $base)->count();
        $totalRevenue = (float) (clone $base)->sum('delivery_fee');
        $delivered = (clone $base)->where('status', 'delivered')->count();
        $cancelled = (clone $base)->where('status', 'cancelled')->count();
        $activeDrivers = Driver::where('status', 'active')->count();
        $customers = Customer::count();

        return view('reports.index', compact('from', 'to', 'totalOrders', 'totalRevenue', 'delivered', 'cancelled', 'activeDrivers', 'customers'));
    }

    public function export(Request $request)
    {
        abort_unless(auth()->user()->can('manage-finances'), 403);
        $from = $request->date('from')?->startOfDay();
        $to = $request->date('to')?->endOfDay();

        return response()->streamDownload(function () use ($from, $to) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['رقم الطلب', 'الحالة', 'العميل', 'الهاتف', 'المنطقة', 'السائق', 'أجرة التوصيل', 'حالة الدفع', 'التاريخ']);
            $query = Order::with(['customer', 'district', 'driver'])->latest();
            if ($from && $to) $query->whereBetween('created_at', [$from, $to]);
            $query->chunk(500, function ($orders) use ($handle) {
                foreach ($orders as $order) {
                    fputcsv($handle, [
                        $order->order_number, $order->statusLabel(), $order->customer?->name,
                        $order->customer_phone_snapshot ?: $order->customer?->phone, $order->district?->name,
                        $order->driver?->name, $order->delivery_fee, $order->paymentStatusLabel(), optional($order->created_at)->format('Y-m-d H:i'),
                    ]);
                }
            });
            fclose($handle);
        }, 'orders-'.now()->format('Y-m-d').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
