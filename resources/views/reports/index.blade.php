<x-app-layout>
@section('page_title','التقارير')
<div class="mx-auto max-w-7xl space-y-5">
    <div class="rounded-3xl bg-gradient-to-l from-slate-950 via-slate-900 to-orange-700 p-6 text-white shadow-xl md:p-8"><div class="flex flex-col justify-between gap-4 md:flex-row md:items-end"><div><div class="text-sm font-semibold text-orange-200">التحليل والتقارير</div><h1 class="mt-2 text-3xl font-black">التقارير</h1><p class="mt-2 text-sm text-white/70">هوية موحدة لقراءة الأداء التشغيلي والمالي بسرعة.</p></div><a href="{{ route('reports.export',['from'=>$from->toDateString(),'to'=>$to->toDateString()]) }}" class="rounded-2xl bg-white px-5 py-3 text-sm font-black text-slate-950">تصدير CSV</a></div></div>

    <form class="grid gap-3 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm md:grid-cols-3"><label class="text-sm font-bold">من<input type="date" name="from" value="{{ $from->toDateString() }}" class="mt-2 w-full rounded-2xl border-slate-200"></label><label class="text-sm font-bold">إلى<input type="date" name="to" value="{{ $to->toDateString() }}" class="mt-2 w-full rounded-2xl border-slate-200"></label><button class="self-end rounded-2xl bg-orange-500 px-4 py-3 font-bold text-white">تطبيق الفترة</button></form>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
        @php($cards=[
            ['label'=>'إجمالي الطلبات','value'=>number_format($totalOrders),'bg'=>'bg-sky-50','text'=>'text-sky-700'],
            ['label'=>'أجور التوصيل','value'=>number_format($totalRevenue,0).' ل.س','bg'=>'bg-violet-50','text'=>'text-violet-700'],
            ['label'=>'تم التسليم','value'=>number_format($delivered),'bg'=>'bg-emerald-50','text'=>'text-emerald-700'],
            ['label'=>'ملغاة','value'=>number_format($cancelled),'bg'=>'bg-rose-50','text'=>'text-rose-700'],
            ['label'=>'السائقون النشطون','value'=>number_format($activeDrivers),'bg'=>'bg-orange-50','text'=>'text-orange-700'],
            ['label'=>'العملاء','value'=>number_format($customers),'bg'=>'bg-cyan-50','text'=>'text-cyan-700'],
        ])
        @foreach($cards as $card)<div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg"><div class="flex items-center justify-between"><span class="text-xs font-bold text-slate-500">{{ $card['label'] }}</span><span class="grid h-10 w-10 place-items-center rounded-xl {{ $card['bg'] }} {{ $card['text'] }}">●</span></div><div class="mt-3 text-2xl font-black">{{ $card['value'] }}</div></div>@endforeach
    </div>
</div>
</x-app-layout>
