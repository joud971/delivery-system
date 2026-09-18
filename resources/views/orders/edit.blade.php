<x-app-layout>
@section('page_title','تعديل الطلب')
<div class="mx-auto max-w-5xl space-y-5">
    <div class="rounded-3xl bg-gradient-to-l from-slate-950 via-slate-900 to-orange-700 p-6 text-white shadow-xl md:p-8"><div class="text-sm font-semibold text-orange-200">{{ $order->order_number }}</div><h1 class="mt-2 text-3xl font-black">تعديل الطلب</h1><p class="mt-2 text-sm text-white/70">تعديل الحالة، الإسناد والملاحظات التشغيلية.</p></div>
    <form method="POST" action="{{ route('orders.update',$order) }}" class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">@csrf @method('PATCH')
        <div class="grid gap-5 md:grid-cols-2">
            <label class="text-sm font-bold">المنطقة<select name="district_id" class="mt-2 w-full rounded-2xl border-slate-200"><option value="">بدون تغيير</option>@foreach($districts as $district)<option value="{{ $district->id }}" @selected($order->district_id===$district->id)>{{ $district->name }}</option>@endforeach</select></label>
            <label class="text-sm font-bold">السائق<select name="driver_id" class="mt-2 w-full rounded-2xl border-slate-200"><option value="">غير مسند</option>@foreach($drivers as $driver)<option value="{{ $driver->id }}" @selected($order->driver_id===$driver->id)>{{ $driver->name }}{{ $driver->is_available ? ' — متاح' : ' — مشغول' }}</option>@endforeach</select></label>
            <label class="text-sm font-bold">الحالة<select name="status" class="mt-2 w-full rounded-2xl border-slate-200"><option value="">بدون تغيير</option>@foreach(\App\Models\Order::STATUSES as $key=>$label)<option value="{{ $key }}" @selected($order->status===$key)>{{ $label }}</option>@endforeach</select></label>
            <label class="text-sm font-bold">حالة الدفع<select name="payment_status" class="mt-2 w-full rounded-2xl border-slate-200">@foreach(\App\Models\Order::PAYMENT_STATUSES as $key=>$label)<option value="{{ $key }}" @selected($order->payment_status===$key)>{{ $label }}</option>@endforeach</select></label>
            <label class="text-sm font-bold">الأولوية<select name="priority" class="mt-2 w-full rounded-2xl border-slate-200"><option value="normal" @selected($order->priority==='normal')>عادي</option><option value="urgent" @selected($order->priority==='urgent')>مستعجل</option></select></label>
            <div class="rounded-2xl bg-slate-50 p-4"><div class="text-xs text-slate-400">أجرة التوصيل</div><div class="mt-1 text-xl font-black">{{ number_format($order->delivery_fee,0) }} ل.س</div><div class="mt-1 text-xs text-slate-400">طريقة الدفع: {{ $order->paymentMethodLabel() }}</div></div>
            <label class="text-sm font-bold md:col-span-2">ملاحظات للموصل<textarea name="driver_notes" rows="3" class="mt-2 w-full rounded-2xl border-slate-200">{{ old('driver_notes',$order->driver_notes) }}</textarea></label>
            <label class="text-sm font-bold md:col-span-2">ملاحظات عامة<textarea name="notes" rows="3" class="mt-2 w-full rounded-2xl border-slate-200">{{ old('notes',$order->notes) }}</textarea></label>
            <label class="text-sm font-bold md:col-span-2">ملاحظة تغيير الحالة<textarea name="transition_note" rows="2" class="mt-2 w-full rounded-2xl border-slate-200" placeholder="سبب تغيير الحالة أو ملاحظة داخلية..."></textarea></label>
        </div>
        <div class="mt-6 flex gap-3"><button class="rounded-2xl bg-slate-950 px-5 py-3 text-sm font-black text-white">حفظ التعديلات</button><a href="{{ route('orders.show',$order) }}" class="rounded-2xl border border-slate-200 px-5 py-3 text-sm font-bold">إلغاء</a></div>
    </form>
</div>
</x-app-layout>
