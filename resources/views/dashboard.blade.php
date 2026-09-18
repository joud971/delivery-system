@php
    $statusLabels = \App\Models\Order::STATUSES;
@endphp
<x-app-layout>
    @section('title', 'لوحة التحكم | الخواجة')
    @section('page_title', 'لوحة التحكم')
    <div class="mx-auto max-w-7xl space-y-6">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-end"><div><div class="text-sm font-semibold text-orange-500">ملخص اليوم</div><h1 class="mt-1 text-3xl font-black text-slate-950">مرحبًا، {{ auth()->user()->name }} 👋</h1><p class="mt-2 text-sm text-slate-500">نظرة مباشرة على حركة الطلبات والأداء المالي والتشغيلي.</p></div><a href="{{ route('orders.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-slate-950 px-5 py-3 text-sm font-bold text-white shadow-lg hover:bg-slate-800">＋ إرسال طلب جديد</a></div>

        @php($statColors = [
            ['bg' => 'bg-orange-500', 'shadow' => 'shadow-orange-500/20'],
            ['bg' => 'bg-sky-500', 'shadow' => 'shadow-sky-500/20'],
            ['bg' => 'bg-violet-500', 'shadow' => 'shadow-violet-500/20'],
            ['bg' => 'bg-emerald-500', 'shadow' => 'shadow-emerald-500/20'],
            ['bg' => 'bg-rose-500', 'shadow' => 'shadow-rose-500/20'],
            ['bg' => 'bg-amber-500', 'shadow' => 'shadow-amber-500/20'],
            ['bg' => 'bg-cyan-500', 'shadow' => 'shadow-cyan-500/20'],
            ['bg' => 'bg-indigo-500', 'shadow' => 'shadow-indigo-500/20'],
        ])
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach($stats as $index => $stat)
                @php($color = $statColors[$index % count($statColors)])
                <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-xl">
                    <div class="absolute -left-8 -top-8 h-24 w-24 rounded-full bg-slate-50 opacity-70 transition group-hover:scale-125"></div>
                    <div class="relative flex items-start justify-between">
                        <div>
                            <div class="text-sm font-semibold text-slate-500">{{ $stat['label'] }}</div>
                            <div class="mt-2 text-3xl font-black tracking-tight text-slate-950">{{ $stat['value'] }} @isset($stat['suffix'])<span class="text-xs font-bold text-slate-400">{{ $stat['suffix'] }}</span>@endisset</div>
                        </div>
                        <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl {{ $color['bg'] }} text-lg font-black text-white shadow-lg {{ $color['shadow'] }} transition duration-200 group-hover:rotate-3 group-hover:scale-105">{{ $stat['icon'] }}</div>
                    </div>
                    @if(isset($stat['change']) && $stat['change'] !== null)
                        <div class="mt-4 inline-flex rounded-full bg-slate-50 px-2.5 py-1 text-xs font-bold {{ $stat['change'] >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $stat['change'] >= 0 ? '+' : '' }}{{ $stat['change'] }}% مقارنة بالأمس
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="grid gap-6 xl:grid-cols-[1.45fr_0.85fr]">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><div class="mb-5 flex items-center justify-between"><div><h2 class="text-lg font-extrabold">آخر الطلبات</h2><p class="mt-1 text-sm text-slate-500">آخر 10 طلبات دخلت النظام.</p></div><a href="{{ route('orders.index') }}" class="text-sm font-bold text-orange-600">عرض الكل</a></div><div class="overflow-x-auto"><table class="min-w-full text-right text-sm"><thead><tr class="border-b border-slate-200 text-slate-400"><th class="pb-3">الطلب</th><th class="pb-3">العميل</th><th class="pb-3">السائق</th><th class="pb-3">الحالة</th><th class="pb-3">أجرة التوصيل</th></tr></thead><tbody>@forelse($recentOrders as $order)<tr class="border-b border-slate-100"><td class="py-3"><a class="font-bold hover:text-orange-600" href="{{ route('orders.show', $order) }}">{{ $order->order_number }}</a><div class="text-xs text-slate-400">{{ $order->created_at?->diffForHumans() }}</div></td><td class="py-3">{{ $order->customer_name_snapshot ?: $order->customer?->name }}</td><td class="py-3">{{ $order->driver?->name ?? 'غير مسند' }}</td><td class="py-3"><span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-bold">{{ $order->statusLabel() }}</span></td><td class="py-3 font-bold">{{ number_format($order->delivery_fee,0) }} ل.س</td></tr>@empty<tr><td colspan="5" class="py-10 text-center text-slate-400">لا توجد طلبات بعد.</td></tr>@endforelse</tbody></table></div></div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><h2 class="text-lg font-extrabold">أداء السائقين</h2><p class="mt-1 text-sm text-slate-500">تسليمات الطلبات الحالية.</p><div class="mt-5 space-y-3">@forelse($topDrivers as $driver)<a href="{{ route('drivers.show',$driver) }}" class="block rounded-2xl border border-slate-100 p-4 transition hover:border-orange-200 hover:bg-orange-50/30"><div class="flex items-center justify-between"><span class="font-bold">{{ $driver->name }}</span><span class="text-xs text-slate-400">{{ $driver->is_available ? 'متاح' : 'مشغول' }}</span></div><div class="mt-3 grid grid-cols-2 gap-2"><div class="rounded-xl bg-slate-50 p-2"><div class="text-[11px] text-slate-400">تم التسليم</div><div class="mt-1 font-black">{{ $driver->delivered_orders_count }}</div></div><div class="rounded-xl bg-slate-50 p-2"><div class="text-[11px] text-slate-400">حاليًا</div><div class="mt-1 font-black">{{ $driver->current_orders_count }}</div></div></div></a>@empty<p class="text-sm text-slate-400">لا توجد بيانات سائقين.</p>@endforelse</div></div>
        </div>
    </div>
</x-app-layout>
