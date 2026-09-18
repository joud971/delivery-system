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
<?php $__env->startSection('page_title','الحسابات'); ?>
<div class="mx-auto max-w-7xl space-y-5">
    <div class="rounded-3xl bg-gradient-to-l from-slate-950 via-slate-900 to-orange-700 p-6 text-white shadow-xl md:p-8">
        <div><div class="text-sm font-semibold text-orange-200">الإدارة المالية</div><h1 class="mt-2 text-3xl font-black">الحسابات</h1><p class="mt-2 text-sm text-white/70">كل الحسابات التشغيلية مبنية على أجرة التوصيل فقط.</p></div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <?php ($cards = [
            ['label'=>'طلبات اليوم','value'=>number_format($dailyOrderCount),'suffix'=>'طلب','bg'=>'bg-sky-50','text'=>'text-sky-700'],
            ['label'=>'إجمالي أجور التوصيل','value'=>number_format($deliveryFeesTotal,0),'suffix'=>'ل.س','bg'=>'bg-violet-50','text'=>'text-violet-700'],
            ['label'=>'المقبوض','value'=>number_format($received,0),'suffix'=>'ل.س','bg'=>'bg-emerald-50','text'=>'text-emerald-700'],
            ['label'=>'المستحقات','value'=>number_format($outstanding,0),'suffix'=>'ل.س','bg'=>'bg-amber-50','text'=>'text-amber-700'],
            ['label'=>'الربح التقديري','value'=>number_format($profit,0),'suffix'=>'ل.س','bg'=>'bg-orange-50','text'=>'text-orange-700'],
        ]); ?>
        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg"><div class="flex items-center justify-between"><span class="text-sm font-bold text-slate-500"><?php echo e($card['label']); ?></span><span class="grid h-10 w-10 place-items-center rounded-xl <?php echo e($card['bg']); ?> <?php echo e($card['text']); ?>">₤</span></div><div class="mt-3 text-2xl font-black"><?php echo e($card['value']); ?> <span class="text-xs font-bold text-slate-400"><?php echo e($card['suffix']); ?></span></div></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="grid gap-5 xl:grid-cols-2">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm"><div class="flex items-center gap-3"><div class="grid h-11 w-11 place-items-center rounded-2xl bg-orange-50 text-orange-600">＋</div><div><h2 class="text-lg font-black">تسجيل مصروف</h2><p class="text-sm text-slate-400">أضف المصروفات التشغيلية للحسابات.</p></div></div><form method="POST" action="<?php echo e(route('expenses.store')); ?>" class="mt-5 grid gap-3 md:grid-cols-2"><?php echo csrf_field(); ?><input name="category" required placeholder="الفئة" class="rounded-2xl border-slate-200"><input name="amount" type="number" min="0" step="0.01" required placeholder="المبلغ" class="rounded-2xl border-slate-200"><input name="expense_date" type="date" required value="<?php echo e(now()->toDateString()); ?>" class="rounded-2xl border-slate-200"><input name="description" placeholder="وصف" class="rounded-2xl border-slate-200"><button class="md:col-span-2 rounded-2xl bg-slate-950 px-4 py-3 font-bold text-white">حفظ المصروف</button></form></div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm"><div class="flex items-center gap-3"><div class="grid h-11 w-11 place-items-center rounded-2xl bg-emerald-50 text-emerald-600">↗</div><div><h2 class="text-lg font-black">آخر المصروفات</h2><p class="text-sm text-slate-400">آخر العمليات المسجلة.</p></div></div><div class="mt-5 space-y-3"><?php $__empty_1 = true; $__currentLoopData = $latestExpenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><div class="flex items-center justify-between rounded-2xl bg-slate-50 p-4"><div><div class="font-black"><?php echo e($expense->category); ?></div><div class="mt-1 text-xs text-slate-400"><?php echo e($expense->expense_date); ?></div></div><div class="font-black"><?php echo e(number_format($expense->amount,0)); ?> ل.س</div></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><p class="text-sm text-slate-400">لا توجد مصروفات.</p><?php endif; ?></div></div>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm"><div class="border-b border-slate-100 p-5"><h2 class="text-lg font-black">آخر العمليات المالية</h2><p class="mt-1 text-sm text-slate-400">المستحقات هنا تعتمد على أجرة التوصيل فقط.</p></div><div class="overflow-x-auto"><table class="min-w-full text-right text-sm"><thead class="bg-slate-950 text-white"><tr><th class="px-5 py-4">الطلب</th><th class="px-5 py-4">العميل</th><th class="px-5 py-4">أجرة التوصيل</th><th class="px-5 py-4">المدفوع</th><th class="px-5 py-4">المتبقي</th></tr></thead><tbody><?php $__currentLoopData = $latestOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><tr class="border-b border-slate-100"><td class="px-5 py-4 font-black"><?php echo e($order->order_number); ?></td><td class="px-5 py-4"><?php echo e($order->customer?->name); ?></td><td class="px-5 py-4 font-bold"><?php echo e(number_format($order->delivery_fee,0)); ?></td><td class="px-5 py-4 font-bold text-emerald-600"><?php echo e(number_format($order->payments->where('status','paid')->sum('amount'),0)); ?></td><td class="px-5 py-4 font-black text-rose-600"><?php echo e(number_format($order->remainingAmount(),0)); ?></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></tbody></table></div></div>
</div>
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
<?php /**PATH C:\Users\HP\Downloads\al-khawaja-final-v2-full\al-khawaja-delivery-full\resources\views/finance/index.blade.php ENDPATH**/ ?>