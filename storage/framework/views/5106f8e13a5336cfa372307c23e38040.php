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
<?php $__env->startSection('page_title','السائقون'); ?>
<div class="mx-auto max-w-7xl space-y-5">
    <div class="rounded-3xl bg-gradient-to-l from-slate-950 via-slate-900 to-violet-700 p-6 text-white shadow-xl md:p-8"><div class="flex flex-col justify-between gap-4 md:flex-row md:items-end"><div><div class="text-sm font-semibold text-violet-200">إدارة السائقين</div><h1 class="mt-2 text-3xl font-black">السائقون</h1><p class="mt-2 text-sm text-white/70">عرض الحالة، الطلبات، الدوام والأداء في واجهة موحدة.</p></div><a href="<?php echo e(route('drivers.create')); ?>" class="rounded-2xl bg-white px-5 py-3 text-sm font-black text-slate-950">＋ إضافة سائق</a></div></div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <?php ($driverStats=[
            ['label'=>'إجمالي السائقين','value'=>$drivers->total(),'bg'=>'bg-sky-50','text'=>'text-sky-700'],
            ['label'=>'متاحون الآن','value'=>\App\Models\Driver::where('status','active')->where('is_available',true)->count(),'bg'=>'bg-emerald-50','text'=>'text-emerald-700'],
            ['label'=>'مشغولون','value'=>\App\Models\Driver::where('status','active')->where('is_available',false)->count(),'bg'=>'bg-amber-50','text'=>'text-amber-700'],
            ['label'=>'طلبات قيد التنفيذ','value'=>\App\Models\Order::whereIn('status',['assigned','confirmed','in_transit'])->count(),'bg'=>'bg-violet-50','text'=>'text-violet-700'],
        ]); ?>
        <?php $__currentLoopData = $driverStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><div class="flex items-center justify-between"><span class="text-sm font-bold text-slate-500"><?php echo e($stat['label']); ?></span><span class="grid h-10 w-10 place-items-center rounded-xl <?php echo e($stat['bg']); ?> <?php echo e($stat['text']); ?>">◉</span></div><div class="mt-3 text-3xl font-black"><?php echo e(number_format($stat['value'])); ?></div></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        <?php $__empty_1 = true; $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="group overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                <div class="h-2 bg-gradient-to-l from-orange-500 to-violet-500"></div>
                <div class="p-5">
                    <div class="flex items-start justify-between gap-3"><div class="flex items-center gap-3"><div class="grid h-12 w-12 place-items-center rounded-2xl bg-slate-950 text-sm font-black text-white"><?php echo e(mb_substr($driver->name,0,1)); ?></div><div><h2 class="font-black"><?php echo e($driver->name); ?></h2><div class="mt-1 text-xs text-slate-400"><?php echo e($driver->phone); ?></div></div></div><span class="rounded-full <?php echo e($driver->is_available ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700'); ?> px-3 py-1.5 text-[11px] font-black"><?php echo e($driver->is_available ? 'متاح' : 'مشغول'); ?></span></div>
                    <div class="mt-5 grid grid-cols-2 gap-3"><div class="rounded-2xl bg-slate-50 p-3"><div class="text-[11px] text-slate-400">الطلبات</div><div class="mt-1 text-xl font-black"><?php echo e($driver->orders_count); ?></div></div><div class="rounded-2xl bg-orange-50 p-3"><div class="text-[11px] text-orange-500">الأرباح</div><div class="mt-1 text-xl font-black text-orange-700"><?php echo e(number_format($driver->earnings_total,0)); ?></div></div></div>
                    <div class="mt-4 flex items-center justify-between text-xs text-slate-500"><span>المركبة: <?php echo e($driver->vehicle_type); ?> <?php echo e($driver->vehicle_plate); ?></span><span>★ <?php echo e($driver->rating); ?></span></div>
                    <a href="<?php echo e(route('drivers.show',$driver)); ?>" class="mt-5 flex items-center justify-center rounded-2xl bg-slate-950 px-4 py-3 text-sm font-black text-white transition group-hover:bg-orange-500">عرض ملف السائق</a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full rounded-3xl border border-dashed border-slate-300 bg-white p-12 text-center text-slate-400">لا يوجد سائقون مسجلون.</div>
        <?php endif; ?>
    </div>
    <div><?php echo e($drivers->links()); ?></div>
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
<?php /**PATH C:\Users\HP\Downloads\al-khawaja-final-v2-full\al-khawaja-delivery-full\resources\views/drivers/index.blade.php ENDPATH**/ ?>