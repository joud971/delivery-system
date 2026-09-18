<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\DriverLocation;
use App\Models\DriverWorkSession;
use App\Models\Order;
use App\Services\OrderWorkflowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{
    public function orders(Request $request)
    {
        $driver = $request->user()->driverProfile;
        abort_unless($driver, 403, 'حساب السائق غير مكتمل.');

        return response()->json($driver->orders()->with(['customer', 'district'])->latest()->paginate(20));
    }

    public function updateOrderStatus(Request $request, Order $order, OrderWorkflowService $workflow)
    {
        abort_unless($order->driver_id === $request->user()->driverProfile?->id, 403);

        $data = $request->validate([
            'status' => 'required|in:confirmed,in_transit,delivered,failed',
            'note' => 'nullable|string|max:1000',
        ]);

        $workflow->transition($order, $data['status'], $request->user(), $data['note'] ?? null);

        return response()->json(['order' => $order->fresh(), 'message' => 'تم تحديث حالة الطلب.']);
    }

    public function startSession(Request $request)
    {
        $driver = $request->user()->driverProfile;
        abort_unless($driver, 403);

        $session = DB::transaction(function () use ($driver) {
            $driver->update(['is_available' => true, 'status' => 'active']);

            return DriverWorkSession::create([
                'driver_id' => $driver->id,
                'started_at' => now(),
                'status' => 'open',
            ]);
        });

        return response()->json(['session' => $session], 201);
    }

    public function endSession(Request $request, DriverWorkSession $session)
    {
        abort_unless($session->driver_id === $request->user()->driverProfile?->id, 403);
        abort_if($session->status === 'closed', 422, 'جلسة العمل مغلقة مسبقًا.');

        $session->update([
            'ended_at' => now(),
            'total_minutes' => $session->started_at->diffInMinutes(now()),
            'status' => 'closed',
        ]);
        $session->driver->update(['is_available' => false]);

        return response()->json(['session' => $session->fresh()]);
    }

    public function location(Request $request)
    {
        $driver = $request->user()->driverProfile;
        abort_unless($driver, 403);

        $data = $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'accuracy' => 'nullable|numeric|min:0',
        ]);

        return response()->json([
            'location' => DriverLocation::create(array_merge($data, [
                'driver_id' => $driver->id,
                'recorded_at' => now(),
            ])),
        ], 201);
    }
}