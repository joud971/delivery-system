<x-app-layout>
@section('page_title','طلبات السائق')
<div class="mx-auto max-w-6xl space-y-5" x-data="driverPortal({{ $unreadCount }})">
    <div class="rounded-3xl bg-gradient-to-l from-slate-950 via-slate-900 to-orange-700 p-6 text-white shadow-xl md:p-8">
        <div class="flex flex-col justify-between gap-5 md:flex-row md:items-end">
            <div><div class="text-sm font-semibold text-orange-200">مساحة السائق</div><h1 class="mt-2 text-3xl font-black">مرحبًا، {{ $driver->name }} 👋</h1><p class="mt-2 text-sm leading-7 text-white/70">من هنا ترى الطلبات المسندة إليك، تقبل الطلب وتتابع عملية التوصيل حتى التسليم.</p></div>
            <div class="rounded-2xl bg-white/10 px-5 py-4 backdrop-blur"><div class="text-xs text-white/60">حالتك الحالية</div><div class="mt-1 font-black">{{ $driver->is_available ? 'متاح للعمل' : 'مشغول / خارج التوفر' }}</div></div>
        </div>
    </div>

    <div x-show="newAlert" x-cloak class="rounded-2xl border border-orange-200 bg-orange-50 px-5 py-4 text-sm font-bold text-orange-900 shadow-sm"><span x-text="alertMessage"></span></div>

    @php($openSession = $driver->workSessions()->where('status','open')->latest('started_at')->first())
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><div class="text-sm font-bold text-slate-500">طلباتك الحالية</div><div class="mt-2 text-3xl font-black">{{ $orders->count() }}</div></div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><div class="text-sm font-bold text-slate-500">طلبات بانتظار القبول</div><div class="mt-2 text-3xl font-black text-orange-600">{{ $orders->where('status','assigned')->count() }}</div></div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><div class="text-sm font-bold text-slate-500">آخر منطقة مكتملة</div><div class="mt-2 text-lg font-black">{{ $lastCompletedOrder?->district?->name ?? 'لا يوجد' }}</div></div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><div class="text-sm font-bold text-slate-500">الدوام</div><div class="mt-2 text-lg font-black">{{ $openSession ? 'مسجل الآن' : 'غير مسجل' }}</div></div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm md:p-7">
        <div class="mb-5 flex flex-col justify-between gap-3 md:flex-row md:items-center"><div><h2 class="text-xl font-black">طلباتك</h2><p class="mt-1 text-sm text-slate-400">أي طلب جديد يتم إسناده إليك يظهر هنا ويصلك إشعار.</p></div><div class="flex gap-2">@if(!$openSession)<form method="POST" action="{{ route('driver.work.start') }}">@csrf<button class="rounded-2xl bg-emerald-500 px-4 py-2.5 text-sm font-black text-white">بدء الدوام</button></form>@else<form method="POST" action="{{ route('driver.work.end') }}">@csrf<button class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-2.5 text-sm font-black text-rose-700">إنهاء الدوام</button></form>@endif</div></div>

        <div class="space-y-4">
            @forelse($orders as $order)
                <div class="rounded-3xl border border-slate-200 p-5 transition hover:-translate-y-0.5 hover:shadow-lg">
                    <div class="flex flex-col justify-between gap-4 lg:flex-row lg:items-center">
                        <div class="flex items-start gap-4"><div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-slate-950 text-sm font-black text-white">{{ $order->priority === 'urgent' ? '!' : '✓' }}</div><div><div class="flex flex-wrap items-center gap-2"><span class="font-black">{{ $order->order_number }}</span><span class="rounded-full {{ $order->priority === 'urgent' ? 'bg-rose-50 text-rose-700' : 'bg-sky-50 text-sky-700' }} px-3 py-1 text-[11px] font-black">{{ $order->priorityLabel() }}</span></div><div class="mt-2 text-sm text-slate-500">{{ $order->customer_name_snapshot }} · {{ $order->customer_phone_snapshot }}</div><div class="mt-1 text-xs text-slate-400">{{ $order->district?->name }} · {{ $order->address_snapshot ?: 'العنوان غير محدد' }}</div></div></div>
                        <div class="flex flex-wrap gap-2">@if($order->status === 'assigned')<form method="POST" action="{{ route('driver.orders.accept',$order) }}">@csrf<button class="rounded-2xl bg-orange-500 px-5 py-2.5 text-sm font-black text-white">قبول الطلب</button></form>@elseif($order->status === 'confirmed')<form method="POST" action="{{ route('driver.orders.start',$order) }}">@csrf<button class="rounded-2xl bg-sky-600 px-5 py-2.5 text-sm font-black text-white">بدء التوصيل</button></form>@elseif($order->status === 'in_transit')<form method="POST" action="{{ route('driver.orders.complete',$order) }}">@csrf<button class="rounded-2xl bg-emerald-600 px-5 py-2.5 text-sm font-black text-white">تم التسليم</button></form>@endif<a href="{{ route('driver.orders.show',$order) }}" class="rounded-2xl border border-slate-200 px-5 py-2.5 text-sm font-black">تفاصيل الطلب</a></div>
                    </div>
                </div>
            @empty
                <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-12 text-center"><div class="text-4xl">✓</div><h3 class="mt-3 text-lg font-black">لا توجد طلبات حالية</h3><p class="mt-1 text-sm text-slate-500">عندما يتم إسناد طلب إليك سيظهر هنا ويصلك إشعار.</p></div>
            @endforelse
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm md:p-7">
        <div class="mb-5 flex items-center justify-between"><div><h2 class="text-xl font-black">آخر الإشعارات</h2><p class="mt-1 text-sm text-slate-400">تنبيهات الطلبات والعمليات الخاصة بك.</p></div><a href="{{ route('notifications.index') }}" class="text-sm font-bold text-orange-600">عرض الكل</a></div>
        <div class="space-y-3">@forelse($notifications as $notification)<a href="{{ $notification->related_id && $notification->related_model === \App\Models\Order::class ? route('driver.orders.show',$notification->related_id) : route('notifications.show',$notification) }}" class="block rounded-2xl {{ $notification->is_read ? 'bg-slate-50' : 'bg-orange-50' }} p-4"><div class="flex justify-between gap-4"><div><div class="font-black">{{ $notification->title }}</div><div class="mt-1 text-sm text-slate-500">{{ $notification->message }}</div></div><div class="shrink-0 text-xs text-slate-400">{{ $notification->created_at?->diffForHumans() }}</div></div></a>@empty<p class="text-sm text-slate-400">لا توجد إشعارات بعد.</p>@endforelse</div>
    </div>
</div>

@push('scripts')
<script>
function driverPortal(initialCount) {
    return {
        unreadCount: initialCount,
        lastId: null,
        newAlert: false,
        alertMessage: '',
        async checkNotifications() {
            try {
                const response = await fetch(@json(route('driver.notifications.unread')), { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
                const data = await response.json();
                if (data.latest && this.lastId !== null && data.latest.id > this.lastId) {
                    this.newAlert = true;
                    this.alertMessage = `${data.latest.title}: ${data.latest.message}`;
                    if ('Notification' in window && Notification.permission === 'granted') {
                        new Notification(data.latest.title, { body: data.latest.message });
                    }
                }
                this.lastId = data.latest?.id ?? this.lastId;
                this.unreadCount = data.count;
            } catch (error) {}
        },
        init() {
            this.checkNotifications();
            setInterval(() => this.checkNotifications(), 8000);
        }
    };
}
</script>
@endpush
</x-app-layout>
