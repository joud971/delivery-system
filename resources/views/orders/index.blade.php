<x-app-layout>
@section('page_title','إدارة الطلبات')
<div class="mx-auto max-w-7xl space-y-5" x-data="assignOrderModal()">
    <div class="rounded-3xl bg-gradient-to-l from-slate-950 via-slate-900 to-orange-700 p-6 text-white shadow-xl md:p-8">
        <div class="flex flex-col justify-between gap-5 lg:flex-row lg:items-end">
            <div>
                <div class="text-sm font-semibold text-orange-200">مركز التشغيل</div>
                <h1 class="mt-2 text-3xl font-black">إدارة الطلبات</h1>
                <p class="mt-2 max-w-2xl text-sm leading-7 text-white/70">تابع الطلبات، راقب حالتها، وأرسل كل طلب مباشرة إلى السائق المناسب.</p>
            </div>
            <a href="{{ route('orders.create') }}" class="rounded-2xl bg-white px-5 py-3 text-sm font-black text-slate-950 shadow-lg">＋ إرسال طلب جديد</a>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @php($quickStats = [
            ['label'=>'إجمالي النتائج الحالية','value'=>$orders->total(),'bg'=>'bg-sky-50','text'=>'text-sky-700'],
            ['label'=>'طلبات جديدة','value'=>\App\Models\Order::where('status','new')->count(),'bg'=>'bg-orange-50','text'=>'text-orange-700'],
            ['label'=>'قيد التوصيل','value'=>\App\Models\Order::where('status','in_transit')->count(),'bg'=>'bg-violet-50','text'=>'text-violet-700'],
            ['label'=>'تم التسليم','value'=>\App\Models\Order::where('status','delivered')->count(),'bg'=>'bg-emerald-50','text'=>'text-emerald-700'],
        ])
        @foreach($quickStats as $stat)
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
                <div class="flex items-center justify-between"><span class="text-sm font-bold text-slate-500">{{ $stat['label'] }}</span><span class="grid h-10 w-10 place-items-center rounded-xl {{ $stat['bg'] }} {{ $stat['text'] }}">●</span></div>
                <div class="mt-3 text-3xl font-black">{{ number_format($stat['value']) }}</div>
            </div>
        @endforeach
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
        <form class="grid gap-3 lg:grid-cols-[1.6fr_1fr_1fr_1fr_auto]">
            <input name="q" value="{{ request('q') }}" placeholder="رقم الطلب أو اسم العميل أو الهاتف" class="rounded-2xl border-slate-200">
            <select name="status" class="rounded-2xl border-slate-200"><option value="">كل الحالات</option>@foreach(\App\Models\Order::STATUSES as $key=>$label)<option value="{{ $key }}" @selected(request('status')===$key)>{{ $label }}</option>@endforeach</select>
            <select name="driver_id" class="rounded-2xl border-slate-200"><option value="">كل السائقين</option>@foreach($drivers as $driver)<option value="{{ $driver->id }}" @selected((string)request('driver_id')===(string)$driver->id)>{{ $driver->name }}</option>@endforeach</select>
            <select name="district_id" class="rounded-2xl border-slate-200"><option value="">كل المناطق</option>@foreach($districts as $district)<option value="{{ $district->id }}" @selected((string)request('district_id')===(string)$district->id)>{{ $district->name }}</option>@endforeach</select>
            <div class="flex gap-2"><button class="flex-1 rounded-2xl bg-slate-950 px-5 py-2.5 font-bold text-white">تطبيق</button><a href="{{ route('orders.index') }}" class="grid min-w-16 place-items-center rounded-2xl border border-slate-200">مسح</a></div>
        </form>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-right text-sm">
                <thead class="bg-slate-950 text-white"><tr><th class="px-5 py-4">الطلب</th><th class="px-5 py-4">العميل</th><th class="px-5 py-4">السائق</th><th class="px-5 py-4">المنطقة</th><th class="px-5 py-4">أجرة التوصيل</th><th class="px-5 py-4">الأولوية</th><th class="px-5 py-4">الحالة</th><th class="px-5 py-4">الإجراء</th></tr></thead>
                <tbody>
                @forelse($orders as $order)
                    <tr class="border-b border-slate-100 transition hover:bg-orange-50/30">
                        <td class="px-5 py-4"><a href="{{ route('orders.show',$order) }}" class="font-black text-slate-900 hover:text-orange-600">{{ $order->order_number }}</a><div class="text-xs text-slate-400">{{ $order->created_at?->format('Y-m-d H:i') }}</div></td>
                        <td class="px-5 py-4"><div class="font-bold">{{ $order->customer_name_snapshot ?: $order->customer?->name }}</div><div class="text-xs text-slate-400">{{ $order->customer_phone_snapshot ?: $order->customer?->phone }}</div></td>
                        <td class="px-5 py-4"><span class="inline-flex rounded-full {{ $order->driver ? 'bg-violet-50 text-violet-700' : 'bg-slate-100 text-slate-500' }} px-3 py-1.5 text-xs font-bold">{{ $order->driver?->name ?? 'غير مسند' }}</span></td>
                        <td class="px-5 py-4 text-slate-600">{{ $order->district?->name }}</td>
                        <td class="px-5 py-4 font-black">{{ number_format($order->delivery_fee,0) }} ل.س</td>
                        <td class="px-5 py-4"><span class="rounded-full {{ $order->priority === 'urgent' ? 'bg-rose-50 text-rose-700' : 'bg-sky-50 text-sky-700' }} px-3 py-1.5 text-xs font-bold">{{ $order->priorityLabel() }}</span></td>
                        <td class="px-5 py-4"><span class="rounded-full {{ ['delivered'=>'bg-emerald-50 text-emerald-700','cancelled'=>'bg-rose-50 text-rose-700','in_transit'=>'bg-blue-50 text-blue-700','assigned'=>'bg-violet-50 text-violet-700','confirmed'=>'bg-amber-50 text-amber-700'][$order->status] ?? 'bg-slate-100 text-slate-700' }} px-3 py-1.5 text-xs font-bold">{{ $order->statusLabel() }}</span></td>
                        <td class="px-5 py-4">
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('orders.show',$order) }}" class="rounded-xl bg-slate-100 px-3 py-2 text-xs font-bold">عرض</a>
                                @if(!in_array($order->status,['delivered','cancelled'],true))
                                    @can('assign-orders')
                                        <button type="button" @click="openAssign(@js($order->id), @js($order->order_number), @js(route('orders.assign',$order)))" class="rounded-xl bg-orange-500 px-3 py-2 text-xs font-bold text-white shadow-md shadow-orange-500/10">إرسال للسائق</button>
                                    @endcan
                                @endif
                                @can('update',$order)<a href="{{ route('orders.edit',$order) }}" class="rounded-xl bg-orange-50 px-3 py-2 text-xs font-bold text-orange-700">تعديل</a>@endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="py-16 text-center text-slate-400">لا توجد نتائج مطابقة.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 p-5">{{ $orders->links() }}</div>
    </div>

    <div x-show="open" x-cloak class="fixed inset-0 z-[70] grid place-items-center bg-slate-950/60 p-4 backdrop-blur-sm">
        <div @click.outside="open=false" class="w-full max-w-2xl rounded-3xl bg-white shadow-2xl">
            <div class="flex items-center justify-between border-b border-slate-100 p-5"><div><div class="text-xs font-bold text-orange-500">إسناد الطلب</div><h2 class="mt-1 text-xl font-black" x-text="selectedOrder"></h2></div><button @click="open=false" class="grid h-10 w-10 place-items-center rounded-xl bg-slate-100">×</button></div>
            <form method="POST" :action="assignAction" class="p-5">
                @csrf
                <p class="mb-4 text-sm text-slate-500">اختر أحد السائقين الموجودين على رأس العمل. ستشاهد آخر منطقة أنهى فيها كل سائق طلبًا.</p>
                <div class="grid max-h-[55vh] gap-3 overflow-y-auto">
                    @forelse($workingDrivers as $driver)
                        <label class="group flex cursor-pointer items-center justify-between gap-4 rounded-2xl border border-slate-200 p-4 transition hover:border-orange-300 hover:bg-orange-50/40">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="driver_id" value="{{ $driver->id }}" x-model="selectedDriver" class="h-5 w-5 text-orange-500">
                                <div class="grid h-11 w-11 place-items-center rounded-2xl bg-slate-950 text-sm font-black text-white">{{ mb_substr($driver->name,0,1) }}</div>
                                <div><div class="font-black">{{ $driver->name }}</div><div class="mt-1 text-xs text-slate-400">آخر منطقة: <span class="font-bold text-slate-600">{{ $driver->last_completed_area ?? 'لا يوجد طلب مكتمل' }}</span></div></div>
                            </div>
                            <div class="text-left"><span class="rounded-full {{ $driver->is_available ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }} px-3 py-1.5 text-[11px] font-black">{{ $driver->is_available ? 'متاح الآن' : 'مشغول' }}</span><div class="mt-2 text-xs text-slate-400">{{ $driver->current_orders_count }} طلب حالي</div></div>
                        </label>
                    @empty
                        <div class="rounded-2xl border border-dashed border-slate-300 p-8 text-center text-sm text-slate-500">لا يوجد سائقون على رأس العمل حاليًا.</div>
                    @endforelse
                </div>
                <div class="mt-5 flex justify-end gap-3"><button type="button" @click="open=false" class="rounded-2xl border border-slate-200 px-5 py-3 text-sm font-bold">إلغاء</button><button :disabled="!selectedDriver" class="rounded-2xl bg-orange-500 px-6 py-3 text-sm font-black text-white disabled:cursor-not-allowed disabled:opacity-40">إرسال الطلب</button></div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function assignOrderModal() {
    return {
        open: false,
        selectedOrder: '',
        selectedDriver: '',
        assignAction: '',
        openAssign(id, number, action) {
            this.open = true;
            this.selectedOrder = number;
            this.selectedDriver = '';
            this.assignAction = action;
        }
    };
}
</script>
@endpush
</x-app-layout>
