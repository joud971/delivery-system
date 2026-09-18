<x-app-layout>
    <div class="dashboard-shell px-4 py-6 md:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="panel p-6">
                <div class="mb-5">
                    <h1 class="text-2xl font-bold text-slate-900">الإعدادات</h1>
                    <p class="text-sm text-slate-500">إدارة اسم الشركة، الشعار، الأسعار، والقيم الافتراضية</p>
                </div>
                <form method="POST" action="{{ route('settings.store') }}" class="grid gap-5 md:grid-cols-2">
                    @csrf
                    <label class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm font-semibold">اسم الشركة<input name="company_name" value="{{ $settings->firstWhere('key', 'company_name')?->value ?? '' }}" class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" /></label>
                    <label class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm font-semibold">سعر التوصيل الافتراضي<input name="default_delivery_fee" type="number" min="0" value="{{ $settings->firstWhere('key', 'default_delivery_fee')?->value ?? '' }}" class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" /></label>
                    <div class="md:col-span-2"><button class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white">حفظ الإعداد</button></div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
