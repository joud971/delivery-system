<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\District;
use App\Models\Driver;
use App\Models\Notification;
use App\Models\Order;
use App\Services\OrderWorkflowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct(private OrderWorkflowService $workflow) {}

    public function index(Request $request)
    {
        $this->authorize('viewAny', Order::class);

        $query = Order::with(['customer', 'driver', 'district'])->latest();
        if ($request->filled('q')) {
            $term = trim($request->string('q'));
            $query->where(function ($q) use ($term) {
                $q->where('order_number', 'like', "%{$term}%")
                  ->orWhere('customer_name_snapshot', 'like', "%{$term}%")
                  ->orWhere('customer_phone_snapshot', 'like', "%{$term}%")
                  ->orWhereHas('customer', fn ($customer) => $customer
                      ->where('name', 'like', "%{$term}%")
                      ->orWhere('phone', 'like', "%{$term}%"));
            });
        }
        if ($request->filled('status') && array_key_exists($request->status, Order::STATUSES)) {
            $query->where('status', $request->status);
        }
        if ($request->filled('driver_id')) $query->where('driver_id', $request->driver_id);
        if ($request->filled('district_id')) $query->where('district_id', $request->district_id);

        $orders = $query->paginate(15)->withQueryString();
        $drivers = Driver::orderBy('name')->get(['id', 'name', 'status', 'is_available']);
        $districts = District::orderBy('name')->get(['id', 'name']);

        $workingDrivers = Driver::query()
            ->where('status', 'active')
            ->withCount(['orders as current_orders_count' => fn ($q) => $q->whereIn('status', ['assigned', 'confirmed', 'in_transit'])])
            ->orderByDesc('is_available')
            ->orderBy('name')
            ->get();

        foreach ($workingDrivers as $driver) {
            $lastCompleted = $driver->orders()
                ->with('district')
                ->where('status', 'delivered')
                ->orderByDesc('delivered_at')
                ->orderByDesc('id')
                ->first();
            $driver->setAttribute('last_completed_area', $lastCompleted?->district?->name);
        }

        return view('orders.index', compact('orders', 'drivers', 'districts', 'workingDrivers'));
    }

    public function create()
    {
        $this->authorize('create', Order::class);

        return view('orders.create', [
            'districts' => District::where('status', 'active')->orderBy('name')->get(),
        ]);
    }

    public function customerLookup(Request $request): JsonResponse
    {
        $this->authorize('create', Order::class);

        $phone = trim((string) $request->string('phone'));
        if ($phone === '') {
            return response()->json(['found' => false]);
        }

        $customer = Customer::with('district')->where('phone', $phone)->first();
        if (!$customer) {
            return response()->json(['found' => false]);
        }

        return response()->json([
            'found' => true,
            'customer' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'phone' => $customer->phone,
                'address' => $customer->address,
                'district_id' => $customer->district_id,
                'district_name' => $customer->district?->name,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Order::class);

        $validated = $request->validate([
            'customer_phone' => 'required|string|max:30',
            'customer_name' => 'required|string|max:120',
            'address' => 'nullable|string|max:5000',
            'district_id' => 'required|exists:districts,id',
            'order_details' => 'required|string|max:5000',
            'driver_notes' => 'nullable|string|max:5000',
            'priority' => 'required|in:normal,urgent',
            'delivery_fee' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,transfer',
            'notes' => 'nullable|string|max:5000',
        ]);

        $order = DB::transaction(function () use ($validated) {
            $customer = Customer::where('phone', $validated['customer_phone'])->first();

            if (!$customer) {
                $customer = Customer::create([
                    'name' => $validated['customer_name'],
                    'phone' => $validated['customer_phone'],
                    'address' => $validated['address'] ?? null,
                    'district_id' => $validated['district_id'],
                    'status' => 'active',
                ]);
            } else {
                $customer->update(array_filter([
                    'name' => $validated['customer_name'] ?: $customer->name,
                    'address' => $validated['address'] ?? $customer->address,
                    'district_id' => $validated['district_id'] ?? $customer->district_id,
                ], static fn ($value) => $value !== null));
            }

            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'customer_id' => $customer->id,
                'district_id' => $validated['district_id'],
                'driver_id' => null,
                'status' => 'new',
                'subtotal' => 0,
                'delivery_fee' => $validated['delivery_fee'],
                'total' => $validated['delivery_fee'],
                'payment_status' => 'pending',
                'assigned_by' => null,
                'order_details' => $validated['order_details'],
                'driver_notes' => $validated['driver_notes'] ?? null,
                'priority' => $validated['priority'],
                'payment_method' => $validated['payment_method'],
                'expected_delivery_at' => null,
                'customer_name_snapshot' => $customer->name,
                'customer_phone_snapshot' => $customer->phone,
                'address_snapshot' => $validated['address'] ?? $customer->address,
                'notes' => $validated['notes'] ?? null,
            ]);

            $order->statusHistory()->create([
                'status_to' => 'new',
                'changed_by_user_id' => auth()->id(),
                'note' => 'تم إنشاء الطلب.',
            ]);

            return $order;
        });

        return redirect()->route('orders.show', $order)->with('success', 'تم إنشاء الطلب بنجاح. أصبح جاهزًا للإسناد إلى السائق.');
    }

    public function assignDriver(Request $request, Order $order)
    {
        abort_unless(auth()->user()->can('assign-orders'), 403);
        abort_if(in_array($order->status, ['in_transit', 'delivered', 'cancelled'], true), 422, 'لا يمكن إسناد هذا الطلب في حالته الحالية.');

        $data = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
        ]);

        $newDriver = Driver::whereKey($data['driver_id'])->where('status', 'active')->firstOrFail();
        $previousDriverId = $order->driver_id;
        $wasAssigned = $order->status === 'assigned';

        DB::transaction(function () use ($order, $newDriver, $previousDriverId, $wasAssigned) {
            $order->update([
                'driver_id' => $newDriver->id,
                'assigned_by' => auth()->id(),
            ]);

            if (!$wasAssigned) {
                $this->workflow->transition($order->fresh(), 'assigned', auth()->user(), 'تم إسناد الطلب إلى السائق '.$newDriver->name.'.');
            } elseif ($newDriver->user_id) {
                Notification::create([
                    'user_id' => $newDriver->user_id,
                    'title' => 'طلب جديد مسند إليك',
                    'message' => "تم إسناد الطلب {$order->order_number} إليك.",
                    'type' => 'order',
                    'related_model' => Order::class,
                    'related_id' => $order->id,
                ]);
            }

            if ($previousDriverId && $previousDriverId !== $newDriver->id) {
                $oldDriver = Driver::find($previousDriverId);
                if ($oldDriver?->user_id) {
                    Notification::create([
                        'user_id' => $oldDriver->user_id,
                        'title' => 'تم نقل الطلب',
                        'message' => "تم نقل الطلب {$order->order_number} إلى سائق آخر.",
                        'type' => 'order',
                        'related_model' => Order::class,
                        'related_id' => $order->id,
                    ]);
                }
            }
        });

        return back()->with('success', "تم إرسال الطلب {$order->order_number} إلى السائق {$newDriver->name}.");
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'district', 'driver', 'statusHistory', 'payments']);
        $this->authorize('view', $order);
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $this->authorize('update', $order);
        abort_if(auth()->user()->hasRole('Driver'), 403);

        return view('orders.edit', [
            'order' => $order,
            'districts' => District::where('status', 'active')->orderBy('name')->get(),
            'drivers' => Driver::where('status', 'active')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        if (auth()->user()->hasRole('Driver')) {
            $request->validate([
                'status' => 'nullable|in:confirmed,in_transit,delivered,failed',
                'driver_notes' => 'nullable|string|max:5000',
                'transition_note' => 'nullable|string|max:1000',
            ]);
            $validated = $request->only(['status', 'driver_notes', 'transition_note']);
        } else {
            $validated = $request->validate([
                'driver_id' => 'nullable|exists:drivers,id',
                'district_id' => 'nullable|exists:districts,id',
                'status' => 'nullable|in:'.implode(',', array_keys(Order::STATUSES)),
                'payment_status' => 'nullable|in:'.implode(',', array_keys(Order::PAYMENT_STATUSES)),
                'priority' => 'nullable|in:normal,urgent',
                'driver_notes' => 'nullable|string|max:5000',
                'notes' => 'nullable|string|max:5000',
                'transition_note' => 'nullable|string|max:1000',
            ]);
        }

        if (array_key_exists('driver_id', $validated) && $validated['driver_id'] != $order->driver_id) {
            abort_unless(auth()->user()->can('assign-orders'), 403);
            $newDriver = $validated['driver_id'] ? Driver::whereKey($validated['driver_id'])->where('status', 'active')->firstOrFail() : null;
            abort_if($newDriver && in_array($order->status, ['in_transit', 'delivered', 'cancelled'], true), 422, 'لا يمكن إسناد سائق لطلب في حالته الحالية.');
            $wasAlreadyAssigned = $order->status === 'assigned';
            $order->update([
                'driver_id' => $validated['driver_id'],
                'assigned_by' => $validated['driver_id'] ? auth()->id() : null,
            ]);
            if ($newDriver && !$wasAlreadyAssigned) {
                $this->workflow->transition($order->fresh(), 'assigned', $request->user(), 'تم إسناد الطلب للسائق '.$newDriver->name);
            }
            if ($newDriver?->user_id && $wasAlreadyAssigned) {
                Notification::create([
                    'user_id' => $newDriver->user_id,
                    'title' => 'تم إسناد طلب',
                    'message' => "تم إسناد الطلب {$order->order_number} إليك.",
                    'type' => 'order',
                    'related_model' => Order::class,
                    'related_id' => $order->id,
                ]);
            }
        }

        $plain = collect($validated)->except(['status', 'transition_note', 'driver_id'])->all();
        if ($plain) $order->update($plain);

        if (!empty($validated['status']) && $validated['status'] !== $order->status) {
            $this->workflow->transition($order, $validated['status'], $request->user(), $validated['transition_note'] ?? null);
        }

        return redirect()->route('orders.show', $order)->with('success', 'تم تحديث الطلب بنجاح.');
    }

    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);
        abort_if(in_array($order->status, ['in_transit', 'delivered'], true), 422, 'لا يمكن حذف طلب قيد التوصيل أو تم تسليمه.');
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'تم حذف الطلب.');
    }

    private function generateOrderNumber(): string
    {
        do {
            $number = 'KWJ-'.now()->format('Ymd').'-'.random_int(1000, 9999);
        } while (Order::where('order_number', $number)->exists());
        return $number;
    }
}
