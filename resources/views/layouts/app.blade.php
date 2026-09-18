<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'الخواجة'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="bg-slate-100 text-slate-900 antialiased">
@php($role = auth()->user()->getRoleNames()->first())
<div x-data="{sidebar:false}" class="min-h-screen">
    <div x-show="sidebar" x-cloak @click="sidebar=false" class="fixed inset-0 z-40 bg-slate-950/50 lg:hidden"></div>

    <aside :class="sidebar ? 'translate-x-0' : 'translate-x-full lg:translate-x-0'" class="fixed inset-y-0 right-0 z-50 flex w-72 flex-col border-l border-slate-800 bg-slate-950 text-white shadow-2xl transition-transform duration-200">
        <div class="flex h-20 items-center gap-3 border-b border-white/10 px-6">
            <div class="grid h-11 w-11 place-items-center rounded-2xl bg-orange-500 text-xl font-black shadow-lg shadow-orange-500/20">خ</div>
            <div><div class="text-lg font-extrabold">الخواجة</div><div class="text-xs text-slate-400">Al Khawaja Delivery</div></div>
        </div>

        <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-5 text-sm">
            @if(in_array($role, ['Admin', 'Manager'], true))
                @php($links = [
                    ['route'=>'dashboard','label'=>'لوحة التحكم','icon'=>'⌂'],
                    ['route'=>'orders.index','label'=>'إدارة الطلبات','icon'=>'▣'],
                    ['route'=>'orders.create','label'=>'إرسال طلب','icon'=>'＋'],
                    ['route'=>'drivers.index','label'=>'السائقون','icon'=>'◉'],
                    ['route'=>'customers.index','label'=>'العملاء','icon'=>'◎'],
                    ['route'=>'finance.index','label'=>'الحسابات','icon'=>'₤'],
                    ['route'=>'reports.index','label'=>'التقارير','icon'=>'▤'],
                    ['route'=>'notifications.index','label'=>'الإشعارات','icon'=>'◌'],
                    ['route'=>'districts.index','label'=>'المناطق','icon'=>'⌖'],
                    ['route'=>'settings.index','label'=>'الإعدادات','icon'=>'⚙'],
                ])
            @elseif($role === 'Employee')
                @php($links = [
                    ['route'=>'orders.index','label'=>'إدارة الطلبات','icon'=>'▣'],
                    ['route'=>'orders.create','label'=>'إرسال طلب','icon'=>'＋'],
                ])
            @else
                @php($links = [
                    ['route'=>'driver.portal','label'=>'طلبات السائق','icon'=>'◉'],
                    ['route'=>'notifications.index','label'=>'الإشعارات','icon'=>'◌'],
                ])
            @endif

            @foreach($links as $link)
                <a href="{{ route($link['route']) }}" class="flex items-center gap-3 rounded-xl px-4 py-3 transition {{ request()->routeIs($link['route'].'*') ? 'bg-white/10 text-white shadow-inner' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <span class="grid h-8 w-8 place-items-center rounded-lg bg-white/5">{{ $link['icon'] }}</span>
                    <span>{{ $link['label'] }}</span>
                </a>
            @endforeach

            @if(in_array($role, ['Admin', 'Manager'], true))
                <a href="{{ route('users.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 transition {{ request()->routeIs('users.*') ? 'bg-white/10 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}"><span class="grid h-8 w-8 place-items-center rounded-lg bg-white/5">♙</span><span>الحسابات والمستخدمون</span></a>
                <a href="{{ route('audit-logs.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-slate-400 transition hover:bg-white/5 hover:text-white"><span class="grid h-8 w-8 place-items-center rounded-lg bg-white/5">◫</span><span>سجل العمليات</span></a>
            @endif
        </nav>

        <div class="border-t border-white/10 p-4">
            <a href="{{ route('profile.edit') }}" class="mb-3 block rounded-xl bg-white/5 px-4 py-3 hover:bg-white/10">
                <div class="text-sm font-bold">{{ auth()->user()->name }}</div>
                <div class="mt-1 text-xs text-slate-400">{{ auth()->user()->username }} · {{ $role }}</div>
            </a>
            <form method="POST" action="{{ route('logout') }}">@csrf<button class="w-full rounded-xl border border-white/10 px-4 py-2.5 text-sm text-slate-300 hover:bg-white/5">تسجيل الخروج</button></form>
        </div>
    </aside>

    <main class="min-h-screen lg:mr-72">
        <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur">
            <div class="flex h-20 items-center justify-between px-4 md:px-8">
                <div class="flex items-center gap-3">
                    <button @click="sidebar=true" class="grid h-11 w-11 place-items-center rounded-xl border border-slate-200 bg-white lg:hidden">☰</button>
                    <div><div class="text-sm font-bold text-slate-400">{{ $companyName ?? 'الخواجة' }}</div><div class="text-lg font-extrabold">@yield('page_title', 'لوحة التحكم')</div></div>
                </div>
                <div class="flex items-center gap-2">
                    @if(in_array($role, ['Admin', 'Manager', 'Driver'], true))
                        <a href="{{ route('notifications.index') }}" class="relative grid h-11 w-11 place-items-center rounded-xl border border-slate-200 bg-white text-lg">◌
                            @php($unread = \App\Models\Notification::where('user_id',auth()->id())->where('is_read',false)->count())
                            @if($unread)<span class="absolute -right-1 -top-1 grid min-w-5 h-5 place-items-center rounded-full bg-orange-500 px-1 text-[10px] font-bold text-white">{{ $unread > 99 ? '99+' : $unread }}</span>@endif
                        </a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="hidden items-center gap-3 rounded-xl border border-slate-200 bg-white px-3 py-2 sm:flex"><span class="grid h-9 w-9 place-items-center rounded-full bg-slate-900 text-sm font-bold text-white">{{ mb_substr(auth()->user()->name, 0, 1) }}</span><span class="text-right"><span class="block text-sm font-bold">{{ auth()->user()->name }}</span><span class="block text-xs text-slate-400">{{ $role }}</span></span></a>
                </div>
            </div>
        </header>

        @if(session('success'))<div class="px-4 pt-4 md:px-8"><div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">{{ session('success') }}</div></div>@endif
        @if(session('error'))<div class="px-4 pt-4 md:px-8"><div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">{{ session('error') }}</div></div>@endif
        @if($errors->any())<div class="px-4 pt-4 md:px-8"><div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800"><div class="font-bold">يرجى مراجعة الحقول التالية:</div><ul class="mt-2 list-disc pr-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div></div>@endif

        <main class="p-4 md:p-8">{{ $slot }}</main>
    </main>
</div>
@stack('scripts')
</body>
</html>
