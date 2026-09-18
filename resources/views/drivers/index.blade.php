<x-app-layout>
@section('page_title','السائقون')
<div class="mx-auto max-w-7xl space-y-5">
    <div class="rounded-3xl bg-gradient-to-l from-slate-950 via-slate-900 to-violet-700 p-6 text-white shadow-xl md:p-8"><div class="flex flex-col justify-between gap-4 md:flex-row md:items-end"><div><div class="text-sm font-semibold text-violet-200">إدارة السائقين</div><h1 class="mt-2 text-3xl font-black">السائقون</h1><p class="mt-2 text-sm text-white/70">عرض الحالة، الطلبات، الدوام والأداء في واجهة موحدة.</p></div><a href="{{ route('drivers.create') }}" class="rounded-2xl bg-white px-5 py-3 text-sm font-black text-slate-950">＋ إضافة سائق</a></div></div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @php($driverStats=[
            ['label'=>'إجمالي السائقين','value'=>$drivers->total(),'bg'=>'bg-sky-50','text'=>'text-sky-700'],
            ['label'=>'متاحون الآن','value'=>\App\Models\Driver::where('status','active')->where('is_available',true)->count(),'bg'=>'bg-emerald-50','text'=>'text-emerald-700'],
            ['label'=>'مشغولون','value'=>\App\Models\Driver::where('status','active')->where('is_available',false)->count(),'bg'=>'bg-amber-50','text'=>'text-amber-700'],
            ['label'=>'طلبات قيد التنفيذ','value'=>\App\Models\Order::whereIn('status',['assigned','confirmed','in_transit'])->count(),'bg'=>'bg-violet-50','text'=>'text-violet-700'],
        ])
        @foreach($driverStats as $stat)<div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><div class="flex items-center justify-between"><span class="text-sm font-bold text-slate-500">{{ $stat['label'] }}</span><span class="grid h-10 w-10 place-items-center rounded-xl {{ $stat['bg'] }} {{ $stat['text'] }}">◉</span></div><div class="mt-3 text-3xl font-black">{{ number_format($stat['value']) }}</div></div>@endforeach
    </div>

    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @forelse($drivers as $driver)
            <div class="group overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                <div class="h-2 bg-gradient-to-l from-orange-500 to-violet-500"></div>
                <div class="p-5">
                    <div class="flex items-start justify-between gap-3"><div class="flex items-center gap-3"><div class="grid h-12 w-12 place-items-center rounded-2xl bg-slate-950 text-sm font-black text-white">{{ mb_substr($driver->name,0,1) }}</div><div><h2 class="font-black">{{ $driver->name }}</h2><div class="mt-1 text-xs text-slate-400">{{ $driver->phone }}</div></div></div><span class="rounded-full {{ $driver->is_available ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }} px-3 py-1.5 text-[11px] font-black">{{ $driver->is_available ? 'متاح' : 'مشغول' }}</span></div>
                    <div class="mt-5 grid grid-cols-2 gap-3"><div class="rounded-2xl bg-slate-50 p-3"><div class="text-[11px] text-slate-400">الطلبات</div><div class="mt-1 text-xl font-black">{{ $driver->orders_count }}</div></div><div class="rounded-2xl bg-orange-50 p-3"><div class="text-[11px] text-orange-500">الأرباح</div><div class="mt-1 text-xl font-black text-orange-700">{{ number_format($driver->earnings_total,0) }}</div></div></div>
                    <div class="mt-4 flex items-center justify-between text-xs text-slate-500"><span>المركبة: {{ $driver->vehicle_type }} {{ $driver->vehicle_plate }}</span><span>★ {{ $driver->rating }}</span></div>
                    <a href="{{ route('drivers.show',$driver) }}" class="mt-5 flex items-center justify-center rounded-2xl bg-slate-950 px-4 py-3 text-sm font-black text-white transition group-hover:bg-orange-500">عرض ملف السائق</a>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-3xl border border-dashed border-slate-300 bg-white p-12 text-center text-slate-400">لا يوجد سائقون مسجلون.</div>
        @endforelse
    </div>
    <div>{{ $drivers->links() }}</div>
</div>
</x-app-layout>
