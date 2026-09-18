<?php

namespace App\Http\Controllers;

use App\Models\DriverWorkSession;
use App\Models\Notification;
use App\Models\Order;
use App\Services\OrderWorkflowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverPortalController extends Controller
{
    public function index(Request $request)
    {
        $driver = $request->user()->driverProfile;
        abort_unless($driver, 403, 'حساب السائق غير مكتمل.');

        $orders = $driver->orders()
            ->with('district')
            ->whereIn('status', ['assigned', 'confirmed', 'in_transit'])
            ->latest()
            ->get();

        $unreadCount = Notification::query()
            ->where('user_id', $request->user()->id)
            ->where('is_read', false)
            ->count();

        $notifications = Notification::query()
            ->where('user_id', $request->user()->id)
            ->latest()
            ->limit(6)
            ->get();

        $lastCompletedOrder = $driver->orders()
            ->with('district')
            ->where('status', 'delivered')
            ->latest('delivered_at')
            ->latest('id')
            ->first();

        return view('driver.portal', compact('driver', 'orders', 'unreadCount', 'notifications', 'lastCompletedOrder'));
    }

    public function showOrder(Request $request, Order $order)
    {
        $driver = $request->user()->driverProfile;
        abort_unless($driver && $order->driver_id === $driver->id, 403);

        $order->load(['customer', 'district']);
        return view('driver.order', compact('order', 'driver'));
    }

    public function acceptOrder(Request $request, Order $order, OrderWorkflowService $workflow)
    {
        $driver = $request->user()->driverProfile;
        abort_unless($driver && $order->driver_id === $driver->id, 403);
        abort_if($order->status !== 'assigned', 422, 'هذا الطلب غير متاح للقبول الآن.');

        $workflow->transition($order, 'confirmed', $request->user(), 'تم قبول الطلب من السائق.');

        return back()->with('success', 'تم قبول الطلب بنجاح.');
    }

    public function startDelivery(Request $request, Order $order, OrderWorkflowService $workflow)
    {
        $driver = $request->user()->driverProfile;
        abort_unless($driver && $order->driver_id === $driver->id, 403);
        abort_if($order->status !== 'confirmed', 422, 'يجب قبول الطلب أولًا.');

        $workflow->transition($order, 'in_transit', $request->user(), 'بدأ السائق عملية التوصيل.');

        return back()->with('success', 'تم بدء التوصيل.');
    }

    public function completeDelivery(Request $request, Order $order, OrderWorkflowService $workflow)
    {
        $driver = $request->user()->driverProfile;
        abort_unless($driver && $order->driver_id === $driver->id, 403);
        abort_if($order->status !== 'in_transit', 422, 'لا يمكن إنهاء الطلب قبل بدء التوصيل.');

        $workflow->transition($order, 'delivered', $request->user(), 'تم تسليم الطلب من السائق.');

        return back()->with('success', 'تم تسجيل تسليم الطلب.');
    }

    public function startWork(Request $request)
    {
        $driver = $request->user()->driverProfile;
        abort_unless($driver, 403);

        $existing = DriverWorkSession::where('driver_id', $driver->id)->where('status', 'open')->first();
        if ($existing) {
            return back()->with('success', 'الدوام مسجل بالفعل.');
        }

        DriverWorkSession::create([
            'driver_id' => $driver->id,
            'started_at' => now(),
            'status' => 'open',
        ]);
        $driver->update(['status' => 'active', 'is_available' => true]);

        return back()->with('success', 'تم بدء الدوام.');
    }

    public function endWork(Request $request)
    {
        $driver = $request->user()->driverProfile;
        abort_unless($driver, 403);

        $session = DriverWorkSession::where('driver_id', $driver->id)->where('status', 'open')->latest('started_at')->first();
        abort_unless($session, 422, 'لا توجد جلسة دوام مفتوحة.');

        $session->update([
            'ended_at' => now(),
            'total_minutes' => $session->started_at->diffInMinutes(now()),
            'status' => 'closed',
        ]);
        $driver->update(['is_available' => false]);

        return back()->with('success', 'تم إنهاء الدوام.');
    }

    public function unreadNotifications(Request $request): JsonResponse
    {
        $latest = Notification::query()
            ->where('user_id', $request->user()->id)
            ->where('is_read', false)
            ->latest()
            ->first();

        return response()->json([
            'count' => Notification::where('user_id', $request->user()->id)->where('is_read', false)->count(),
            'latest' => $latest ? [
                'id' => $latest->id,
                'title' => $latest->title,
                'message' => $latest->message,
                'related_id' => $latest->related_id,
            ] : null,
        ]);
    }
}
