<x-app-layout>
@section('page_title','الحسابات')
<div class="mx-auto max-w-7xl space-y-5">
    <div class="rounded-3xl bg-gradient-to-l from-slate-950 via-slate-900 to-orange-700 p-6 text-white shadow-xl md:p-8">
        <div><div class="text-sm font-semibold text-orange-200">الإدارة المالية</div><h1 class="mt-2 text-3xl font-black">الحسابات</h1><p class="mt-2 text-sm text-white/70">كل الحسابات التشغيلية مبنية على أجرة التوصيل فقط.</p></div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
        @php($cards = [
            ['label'=>'طلبات اليوم','value'=>number_format($dailyOrderCount),'suffix'=>'طلب','bg'=>'bg-sky-50','text'=>'text-sky-700'],
            ['label'=>'إجمالي أجور التوصيل','value'=>number_format($deliveryFeesTotal,0),'suffix'=>'ل.س','bg'=>'bg-violet-50','text'=>'text-violet-700'],
            ['label'=>'المقبوض','value'=>number_format($received,0),'suffix'=>'ل.س','bg'=>'bg-emerald-50','text'=>'text-emerald-700'],
            ['label'=>'المستحقات','value'=>number_format($outstanding,0),'suffix'=>'ل.س','bg'=>'bg-amber-50','text'=>'text-amber-700'],
            ['label'=>'الربح التقديري','value'=>number_format($profit,0),'suffix'=>'ل.س','bg'=>'bg-orange-50','text'=>'text-orange-700'],
        ])
        @foreach($cards as $card)
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg"><div class="flex items-center justify-between"><span class="text-sm font-bold text-slate-500">{{ $card['label'] }}</span><span class="grid h-10 w-10 place-items-center rounded-xl {{ $card['bg'] }} {{ $card['text'] }}">₤</span></div><div class="mt-3 text-2xl font-black">{{ $card['value'] }} <span class="text-xs font-bold text-slate-400">{{ $card['suffix'] }}</span></div></div>
        @endforeach
    </div>

    <div class="grid gap-5 xl:grid-cols-2">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm"><div class="flex items-center gap-3"><div class="grid h-11 w-11 place-items-center rounded-2xl bg-orange-50 text-orange-600">＋</div><div><h2 class="text-lg font-black">تسجيل مصروف</h2><p class="text-sm text-slate-400">أضف المصروفات التشغيلية للحسابات.</p></div></div><form method="POST" action="{{ route('expenses.store') }}" class="mt-5 grid gap-3 md:grid-cols-2">@csrf<input name="category" required placeholder="الفئة" class="rounded-2xl border-slate-200"><input name="amount" type="number" min="0" step="0.01" required placeholder="المبلغ" class="rounded-2xl border-slate-200"><input name="expense_date" type="date" required value="{{ now()->toDateString() }}" class="rounded-2xl border-slate-200"><input name="description" placeholder="وصف" class="rounded-2xl border-slate-200"><button class="md:col-span-2 rounded-2xl bg-slate-950 px-4 py-3 font-bold text-white">حفظ المصروف</button></form></div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm"><div class="flex items-center gap-3"><div class="grid h-11 w-11 place-items-center rounded-2xl bg-emerald-50 text-emerald-600">↗</div><div><h2 class="text-lg font-black">آخر المصروفات</h2><p class="text-sm text-slate-400">آخر العمليات المسجلة.</p></div></div><div class="mt-5 space-y-3">@forelse($latestExpenses as $expense)<div class="flex items-center justify-between rounded-2xl bg-slate-50 p-4"><div><div class="font-black">{{ $expense->category }}</div><div class="mt-1 text-xs text-slate-400">{{ $expense->expense_date }}</div></div><div class="font-black">{{ number_format($expense->amount,0) }} ل.س</div></div>@empty<p class="text-sm text-slate-400">لا توجد مصروفات.</p>@endforelse</div></div>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm"><div class="border-b border-slate-100 p-5"><h2 class="text-lg font-black">آخر العمليات المالية</h2><p class="mt-1 text-sm text-slate-400">المستحقات هنا تعتمد على أجرة التوصيل فقط.</p></div><div class="overflow-x-auto"><table class="min-w-full text-right text-sm"><thead class="bg-slate-950 text-white"><tr><th class="px-5 py-4">الطلب</th><th class="px-5 py-4">العميل</th><th class="px-5 py-4">أجرة التوصيل</th><th class="px-5 py-4">المدفوع</th><th class="px-5 py-4">المتبقي</th></tr></thead><tbody>@foreach($latestOrders as $order)<tr class="border-b border-slate-100"><td class="px-5 py-4 font-black">{{ $order->order_number }}</td><td class="px-5 py-4">{{ $order->customer?->name }}</td><td class="px-5 py-4 font-bold">{{ number_format($order->delivery_fee,0) }}</td><td class="px-5 py-4 font-bold text-emerald-600">{{ number_format($order->payments->where('status','paid')->sum('amount'),0) }}</td><td class="px-5 py-4 font-black text-rose-600">{{ number_format($order->remainingAmount(),0) }}</td></tr>@endforeach</tbody></table></div></div>
</div>
</x-app-layout>
