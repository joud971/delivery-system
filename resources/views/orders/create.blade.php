<x-app-layout>
@section('page_title','إرسال طلب جديد')
<div class="mx-auto max-w-6xl space-y-5">
    <div class="rounded-3xl bg-gradient-to-l from-slate-950 via-slate-900 to-orange-700 p-6 text-white shadow-xl md:p-8">
        <div class="max-w-3xl">
            <div class="text-sm font-semibold text-orange-200">عمليات التوصيل</div>
            <h1 class="mt-2 text-3xl font-black">إرسال طلب جديد</h1>
            <p class="mt-2 text-sm leading-7 text-white/70">اكتب رقم العميل، وسنبحث عنه تلقائيًا. بعدها أكمل تفاصيل الطلب وأجرة التوصيل.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('orders.store') }}" class="space-y-5" id="orderCreateForm">
        @csrf

        <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm md:p-7">
            <div class="mb-6 flex items-center gap-3">
                <div class="grid h-11 w-11 place-items-center rounded-2xl bg-orange-50 text-lg font-black text-orange-600">١</div>
                <div><h2 class="text-xl font-black">بيانات العميل والتسليم</h2><p class="text-sm text-slate-500">ابحث بالهاتف واسترجع بيانات العميل السابقة مباشرة.</p></div>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <label class="text-sm font-bold">رقم العميل
                    <div class="relative mt-2">
                        <input id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required autocomplete="tel" class="w-full rounded-2xl border-slate-200 pl-11" placeholder="09xxxxxxxx">
                        <span id="customerLookupState" class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></span>
                    </div>
                </label>

                <label class="text-sm font-bold">اسم العميل
                    <input id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required class="mt-2 w-full rounded-2xl border-slate-200" placeholder="سيظهر تلقائيًا للعميل السابق">
                    <span id="customerFoundMessage" class="mt-2 block text-xs text-slate-400"></span>
                </label>

                <label class="text-sm font-bold md:col-span-2">عنوان التسليم
                    <textarea id="customer_address" name="address" rows="2" class="mt-2 w-full rounded-2xl border-slate-200" placeholder="العنوان بالتفصيل">{{ old('address') }}</textarea>
                </label>

                <label class="text-sm font-bold">المنطقة
                    <select name="district_id" id="district_id" required class="mt-2 w-full rounded-2xl border-slate-200">
                        <option value="">اختر المنطقة</option>
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" data-fee="{{ $district->delivery_fee }}" @selected(old('district_id') == $district->id)>{{ $district->name }} — {{ number_format($district->delivery_fee,0) }} ل.س</option>
                        @endforeach
                    </select>
                </label>

                <label class="text-sm font-bold">الأولوية
                    <select name="priority" class="mt-2 w-full rounded-2xl border-slate-200">
                        <option value="normal" @selected(old('priority') === 'normal')>عادي</option>
                        <option value="urgent" @selected(old('priority') === 'urgent')>مستعجل</option>
                    </select>
                </label>

                <label class="text-sm font-bold md:col-span-2">تفاصيل الطلب
                    <textarea name="order_details" required rows="4" class="mt-2 w-full rounded-2xl border-slate-200" placeholder="مثال: وجبة + مشروب + أي تفاصيل إضافية">{{ old('order_details') }}</textarea>
                </label>

                <label class="text-sm font-bold">ملاحظات للموصل
                    <textarea name="driver_notes" rows="3" class="mt-2 w-full rounded-2xl border-slate-200" placeholder="تفاصيل تساعد السائق عند الوصول">{{ old('driver_notes') }}</textarea>
                </label>

                <label class="text-sm font-bold">ملاحظات إضافية
                    <textarea name="notes" rows="3" class="mt-2 w-full rounded-2xl border-slate-200" placeholder="أي ملاحظة داخلية">{{ old('notes') }}</textarea>
                </label>
            </div>
        </section>

        <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm md:p-7">
            <div class="mb-6 flex items-center gap-3">
                <div class="grid h-11 w-11 place-items-center rounded-2xl bg-emerald-50 text-lg font-black text-emerald-600">٢</div>
                <div><h2 class="text-xl font-black">أجرة التوصيل والدفع</h2><p class="text-sm text-slate-500">لا يوجد في النظام قيمة للطلب؛ الحساب يعتمد على أجرة التوصيل فقط.</p></div>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <label class="text-sm font-bold">أجرة التوصيل
                    <input id="delivery_fee" name="delivery_fee" value="{{ old('delivery_fee') }}" required type="number" min="0" step="0.01" class="mt-2 w-full rounded-2xl border-slate-200" placeholder="15000">
                </label>
                <label class="text-sm font-bold">طريقة الدفع
                    <select name="payment_method" class="mt-2 w-full rounded-2xl border-slate-200">
                        <option value="cash" @selected(old('payment_method', 'cash') === 'cash')>نقدي</option>
                        <option value="transfer" @selected(old('payment_method') === 'transfer')>تحويل</option>
                    </select>
                </label>
            </div>
        </section>

        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('orders.index') }}" class="rounded-2xl border border-slate-200 bg-white px-6 py-3 text-center text-sm font-bold text-slate-700 hover:bg-slate-50">إلغاء</a>
            <button class="rounded-2xl bg-orange-500 px-7 py-3 text-sm font-black text-white shadow-lg shadow-orange-500/20 hover:bg-orange-600">تأكيد وإرسال الطلب</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
(() => {
    const phone = document.getElementById('customer_phone');
    const name = document.getElementById('customer_name');
    const address = document.getElementById('customer_address');
    const district = document.getElementById('district_id');
    const fee = document.getElementById('delivery_fee');
    const state = document.getElementById('customerLookupState');
    const message = document.getElementById('customerFoundMessage');
    const lookupUrl = @json(route('orders.customer-lookup'));
    let timer = null;

    const lookup = async () => {
        const value = phone.value.trim();
        if (!value) {
            message.textContent = '';
            state.textContent = '';
            return;
        }
        state.textContent = '…';
        try {
            const response = await fetch(`${lookupUrl}?phone=${encodeURIComponent(value)}`, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await response.json();
            if (data.found) {
                name.value = data.customer.name || '';
                address.value = data.customer.address || '';
                name.readOnly = true;
                state.textContent = '✓';
                state.className = 'absolute left-3 top-1/2 -translate-y-1/2 text-xs font-black text-emerald-500';
                message.textContent = `تم العثور على العميل${data.customer.district_name ? ` في ${data.customer.district_name}` : ''}`;
                message.className = 'mt-2 block text-xs font-bold text-emerald-600';
                if (data.customer.district_id) {
                    district.value = String(data.customer.district_id);
                    district.dispatchEvent(new Event('change'));
                }
            } else {
                name.readOnly = false;
                state.textContent = '＋';
                state.className = 'absolute left-3 top-1/2 -translate-y-1/2 text-xs font-black text-orange-500';
                message.textContent = 'عميل جديد — أدخل الاسم وأكمل الطلب.';
                message.className = 'mt-2 block text-xs font-bold text-orange-600';
            }
        } catch (error) {
            state.textContent = '';
            message.textContent = 'تعذر البحث الآن، يمكنك إكمال البيانات يدويًا.';
            message.className = 'mt-2 block text-xs text-slate-400';
            name.readOnly = false;
        }
    };

    phone.addEventListener('input', () => {
        clearTimeout(timer);
        timer = setTimeout(lookup, 350);
    });

    district.addEventListener('change', () => {
        const selected = district.selectedOptions[0];
        if (selected?.dataset?.fee && !fee.value) fee.value = selected.dataset.fee;
    });
})();
</script>
@endpush
</x-app-layout>
