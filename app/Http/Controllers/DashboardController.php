<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Driver;
use App\Models\Order;
use App\Models\Setting;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->can('view-dashboard'), 403);

        $today = Carbon::today();
        $yesterday = $today->copy()->subDay();

        $todayOrders = Order::whereDate('created_at', $today)->count();
        $yesterdayOrders = Order::whereDate('created_at', $yesterday)->count();
        $todayRevenue = (float) Order::whereDate('created_at', $today)->sum('delivery_fee');
        $yesterdayRevenue = (float) Order::whereDate('created_at', $yesterday)->sum('delivery_fee');

        $change = static function (float $current, float $previous): int {
            if ($previous <= 0) {
                return $current > 0 ? 100 : 0;
            }
            return (int) round((($current - $previous) / $previous) * 100);
        };

        $stats = [
            ['label' => 'طلبات اليوم', 'value' => number_format($todayOrders), 'change' => $change($todayOrders, $yesterdayOrders), 'icon' => '↗'],
            ['label' => 'طلبات جديدة', 'value' => number_format(Order::where('status', 'new')->count()), 'change' => null, 'icon' => '＋'],
            ['label' => 'قيد التوصيل', 'value' => number_format(Order::where('status', 'in_transit')->count()), 'change' => null, 'icon' => '⌁'],
            ['label' => 'تم التسليم', 'value' => number_format(Order::where('status', 'delivered')->count()), 'change' => null, 'icon' => '✓'],
            ['label' => 'طلبات ملغاة', 'value' => number_format(Order::where('status', 'cancelled')->count()), 'change' => null, 'icon' => '×'],
            ['label' => 'إجمالي أجور التوصيل', 'value' => number_format((float) Order::sum('delivery_fee'), 0, '.', ','), 'suffix' => 'ل.س', 'change' => $change($todayRevenue, $yesterdayRevenue), 'icon' => '₤'],
            ['label' => 'السائقون المتاحون', 'value' => number_format(Driver::where('is_available', true)->where('status', 'active')->count()), 'change' => null, 'icon' => '◉'],
            ['label' => 'العملاء', 'value' => number_format(Customer::count()), 'change' => null, 'icon' => '◎'],
        ];

        $labels = [];
        $ordersSeries = [];
        $revenueSeries = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $labels[] = $date->translatedFormat('D d');
            $ordersSeries[] = Order::whereDate('created_at', $date)->count();
            $revenueSeries[] = (float) Order::whereDate('created_at', $date)->sum('delivery_fee');
        }

        $statusKeys = ['new', 'confirmed', 'assigned', 'in_transit', 'delivered', 'failed', 'cancelled'];
        $statusSeries = collect($statusKeys)->mapWithKeys(fn ($status) => [$status => Order::where('status', $status)->count()])->all();

        $companyName = Setting::where('key', 'company_name')->value('value') ?? 'الخواجة | Al Khawaja Delivery';
        $recentOrders = Order::with(['customer', 'driver', 'district'])->latest()->limit(10)->get();
        $topDrivers = Driver::query()
            ->withCount(['orders as delivered_orders_count' => fn ($query) => $query->where('status', 'delivered')])
            ->withCount(['orders as current_orders_count' => fn ($query) => $query->whereIn('status', ['assigned', 'in_transit'])])
            ->orderByDesc('delivered_orders_count')
            ->limit(5)
            ->get();

        return view('dashboard', compact('stats', 'labels', 'ordersSeries', 'revenueSeries', 'statusSeries', 'companyName', 'recentOrders', 'topDrivers'));
    }
}
