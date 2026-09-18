<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php $__env->startSection('page_title','إرسال طلب جديد'); ?>
<div class="mx-auto max-w-6xl space-y-5">
    <div class="rounded-3xl bg-gradient-to-l from-slate-950 via-slate-900 to-orange-700 p-6 text-white shadow-xl md:p-8">
        <div class="max-w-3xl">
            <div class="text-sm font-semibold text-orange-200">عمليات التوصيل</div>
            <h1 class="mt-2 text-3xl font-black">إرسال طلب جديد</h1>
            <p class="mt-2 text-sm leading-7 text-white/70">اكتب رقم العميل، وسنبحث عنه تلقائيًا. بعدها أكمل تفاصيل الطلب وأجرة التوصيل.</p>
        </div>
    </div>

    <form method="POST" action="<?php echo e(route('orders.store')); ?>" class="space-y-5" id="orderCreateForm">
        <?php echo csrf_field(); ?>

        <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm md:p-7">
            <div class="mb-6 flex items-center gap-3">
                <div class="grid h-11 w-11 place-items-center rounded-2xl bg-orange-50 text-lg font-black text-orange-600">١</div>
                <div><h2 class="text-xl font-black">بيانات العميل والتسليم</h2><p class="text-sm text-slate-500">ابحث بالهاتف واسترجع بيانات العميل السابقة مباشرة.</p></div>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <label class="text-sm font-bold">رقم العميل
                    <div class="relative mt-2">
                        <input id="customer_phone" name="customer_phone" value="<?php echo e(old('customer_phone')); ?>" required autocomplete="tel" class="w-full rounded-2xl border-slate-200 pl-11" placeholder="09xxxxxxxx">
                        <span id="customerLookupState" class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></span>
                    </div>
                </label>

                <label class="text-sm font-bold">اسم العميل
                    <input id="customer_name" name="customer_name" value="<?php echo e(old('customer_name')); ?>" required class="mt-2 w-full rounded-2xl border-slate-200" placeholder="سيظهر تلقائيًا للعميل السابق">
                    <span id="customerFoundMessage" class="mt-2 block text-xs text-slate-400"></span>
                </label>

                <label class="text-sm font-bold md:col-span-2">عنوان التسليم
                    <textarea id="customer_address" name="address" rows="2" class="mt-2 w-full rounded-2xl border-slate-200" placeholder="العنوان بالتفصيل"><?php echo e(old('address')); ?></textarea>
                </label>

                <label class="text-sm font-bold">المنطقة
                    <select name="district_id" id="district_id" required class="mt-2 w-full rounded-2xl border-slate-200">
                        <option value="">اختر المنطقة</option>
                        <?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $district): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($district->id); ?>" data-fee="<?php echo e($district->delivery_fee); ?>" <?php if(old('district_id') == $district->id): echo 'selected'; endif; ?>><?php echo e($district->name); ?> — <?php echo e(number_format($district->delivery_fee,0)); ?> ل.س</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>

                <label class="text-sm font-bold">الأولوية
                    <select name="priority" class="mt-2 w-full rounded-2xl border-slate-200">
                        <option value="normal" <?php if(old('priority') === 'normal'): echo 'selected'; endif; ?>>عادي</option>
                        <option value="urgent" <?php if(old('priority') === 'urgent'): echo 'selected'; endif; ?>>مستعجل</option>
                    </select>
                </label>

                <label class="text-sm font-bold md:col-span-2">تفاصيل الطلب
                    <textarea name="order_details" required rows="4" class="mt-2 w-full rounded-2xl border-slate-200" placeholder="مثال: وجبة + مشروب + أي تفاصيل إضافية"><?php echo e(old('order_details')); ?></textarea>
                </label>

                <label class="text-sm font-bold">ملاحظات للموصل
                    <textarea name="driver_notes" rows="3" class="mt-2 w-full rounded-2xl border-slate-200" placeholder="تفاصيل تساعد السائق عند الوصول"><?php echo e(old('driver_notes')); ?></textarea>
                </label>

                <label class="text-sm font-bold">ملاحظات إضافية
                    <textarea name="notes" rows="3" class="mt-2 w-full rounded-2xl border-slate-200" placeholder="أي ملاحظة داخلية"><?php echo e(old('notes')); ?></textarea>
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
                    <input id="delivery_fee" name="delivery_fee" value="<?php echo e(old('delivery_fee')); ?>" required type="number" min="0" step="0.01" class="mt-2 w-full rounded-2xl border-slate-200" placeholder="15000">
                </label>
                <label class="text-sm font-bold">طريقة الدفع
                    <select name="payment_method" class="mt-2 w-full rounded-2xl border-slate-200">
                        <option value="cash" <?php if(old('payment_method', 'cash') === 'cash'): echo 'selected'; endif; ?>>نقدي</option>
                        <option value="transfer" <?php if(old('payment_method') === 'transfer'): echo 'selected'; endif; ?>>تحويل</option>
                    </select>
                </label>
            </div>
        </section>

        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="<?php echo e(route('orders.index')); ?>" class="rounded-2xl border border-slate-200 bg-white px-6 py-3 text-center text-sm font-bold text-slate-700 hover:bg-slate-50">إلغاء</a>
            <button class="rounded-2xl bg-orange-500 px-7 py-3 text-sm font-black text-white shadow-lg shadow-orange-500/20 hover:bg-orange-600">تأكيد وإرسال الطلب</button>
        </div>
    </form>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
(() => {
    const phone = document.getElementById('customer_phone');
    const name = document.getElementById('customer_name');
    const address = document.getElementById('customer_address');
    const district = document.getElementById('district_id');
    const fee = document.getElementById('delivery_fee');
    const state = document.getElementById('customerLookupState');
    const message = document.getElementById('customerFoundMessage');
    const lookupUrl = <?php echo json_encode(route('orders.customer-lookup'), 15, 512) ?>;
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
<?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\HP\Downloads\al-khawaja-final-v2-full\al-khawaja-delivery-full\resources\views/orders/create.blade.php ENDPATH**/ ?>