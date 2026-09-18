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
<?php $__env->startSection('page_title','التقارير'); ?>
<div class="mx-auto max-w-7xl space-y-5">
    <div class="rounded-3xl bg-gradient-to-l from-slate-950 via-slate-900 to-orange-700 p-6 text-white shadow-xl md:p-8"><div class="flex flex-col justify-between gap-4 md:flex-row md:items-end"><div><div class="text-sm font-semibold text-orange-200">التحليل والتقارير</div><h1 class="mt-2 text-3xl font-black">التقارير</h1><p class="mt-2 text-sm text-white/70">هوية موحدة لقراءة الأداء التشغيلي والمالي بسرعة.</p></div><a href="<?php echo e(route('reports.export',['from'=>$from->toDateString(),'to'=>$to->toDateString()])); ?>" class="rounded-2xl bg-white px-5 py-3 text-sm font-black text-slate-950">تصدير CSV</a></div></div>

    <form class="grid gap-3 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm md:grid-cols-3"><label class="text-sm font-bold">من<input type="date" name="from" value="<?php echo e($from->toDateString()); ?>" class="mt-2 w-full rounded-2xl border-slate-200"></label><label class="text-sm font-bold">إلى<input type="date" name="to" value="<?php echo e($to->toDateString()); ?>" class="mt-2 w-full rounded-2xl border-slate-200"></label><button class="self-end rounded-2xl bg-orange-500 px-4 py-3 font-bold text-white">تطبيق الفترة</button></form>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
        <?php ($cards=[
            ['label'=>'إجمالي الطلبات','value'=>number_format($totalOrders),'bg'=>'bg-sky-50','text'=>'text-sky-700'],
            ['label'=>'أجور التوصيل','value'=>number_format($totalRevenue,0).' ل.س','bg'=>'bg-violet-50','text'=>'text-violet-700'],
            ['label'=>'تم التسليم','value'=>number_format($delivered),'bg'=>'bg-emerald-50','text'=>'text-emerald-700'],
            ['label'=>'ملغاة','value'=>number_format($cancelled),'bg'=>'bg-rose-50','text'=>'text-rose-700'],
            ['label'=>'السائقون النشطون','value'=>number_format($activeDrivers),'bg'=>'bg-orange-50','text'=>'text-orange-700'],
            ['label'=>'العملاء','value'=>number_format($customers),'bg'=>'bg-cyan-50','text'=>'text-cyan-700'],
        ]); ?>
        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg"><div class="flex items-center justify-between"><span class="text-xs font-bold text-slate-500"><?php echo e($card['label']); ?></span><span class="grid h-10 w-10 place-items-center rounded-xl <?php echo e($card['bg']); ?> <?php echo e($card['text']); ?>">●</span></div><div class="mt-3 text-2xl font-black"><?php echo e($card['value']); ?></div></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
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
<?php /**PATH C:\Users\HP\Downloads\al-khawaja-final-v2-full\al-khawaja-delivery-full\resources\views/reports/index.blade.php ENDPATH**/ ?>