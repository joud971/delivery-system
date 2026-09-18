<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'تسجيل الدخول | الخواجة')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-white">
<div class="grid min-h-screen lg:grid-cols-2">
    <div class="relative hidden overflow-hidden lg:block">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(249,115,22,0.28),_transparent_40%),radial-gradient(circle_at_bottom_left,_rgba(37,99,235,0.22),_transparent_40%)]"></div>
        <div class="relative flex h-full flex-col justify-between p-12">
            <div><div class="mb-8 flex items-center gap-3"><div class="grid h-12 w-12 place-items-center rounded-2xl bg-orange-500 text-xl font-black">خ</div><div><div class="text-xl font-extrabold">الخواجة</div><div class="text-xs text-slate-400">Al Khawaja Delivery</div></div></div><h1 class="max-w-lg text-5xl font-black leading-tight">نظام تشغيل ذكي لإدارة التوصيل من مكان واحد.</h1><p class="mt-6 max-w-lg text-lg leading-8 text-slate-400">طلبات، سائقون، عملاء، حسابات وتقارير — بواجهة عربية واضحة وسريعة.</p></div>
            <div class="grid grid-cols-3 gap-3"><div class="rounded-2xl border border-white/10 bg-white/5 p-4"><div class="text-2xl font-black">24/7</div><div class="mt-1 text-xs text-slate-400">مراقبة</div></div><div class="rounded-2xl border border-white/10 bg-white/5 p-4"><div class="text-2xl font-black">RTL</div><div class="mt-1 text-xs text-slate-400">عربي بالكامل</div></div><div class="rounded-2xl border border-white/10 bg-white/5 p-4"><div class="text-2xl font-black">API</div><div class="mt-1 text-xs text-slate-400">جاهز للتطبيق</div></div></div>
        </div>
    </div>
    <div class="flex items-center justify-center p-5 sm:p-10">
        <div class="w-full max-w-md rounded-3xl border border-slate-800 bg-slate-900/90 p-7 shadow-2xl sm:p-9">{{ $slot }}</div>
    </div>
</div>
</body>
</html>
