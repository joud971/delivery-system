<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><div class="dashboard-shell px-4 py-6 md:px-8"><div class="mx-auto max-w-4xl space-y-6"><div class="panel p-6"><div class="flex items-center justify-between"><div><p class="text-sm text-slate-500">ملف السائق</p><h1 class="text-2xl font-bold"><?php echo e($driver->name); ?></h1></div><a href="<?php echo e(route('drivers.edit', $driver)); ?>" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white">تعديل</a></div><div class="mt-6 grid gap-4 md:grid-cols-4"><p>الهاتف: <?php echo e($driver->phone); ?></p><p>المركبة: <?php echo e($driver->vehicle_type); ?></p><p>التقييم: <?php echo e($driver->rating); ?></p><p>الحالة: <?php echo e($driver->is_available ? 'متاح' : 'مشغول'); ?></p></div></div><div class="panel p-6"><h2 class="text-lg font-bold">آخر الطلبات</h2><div class="mt-4 space-y-3"><?php $__empty_1 = true; $__currentLoopData = $driver->orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><a href="<?php echo e(route('orders.show', $order)); ?>" class="flex justify-between rounded-xl border p-3"><span><?php echo e($order->order_number); ?></span><span><?php echo e($order->status); ?></span></a><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><p class="text-slate-500">لا توجد طلبات مسندة.</p><?php endif; ?></div></div><div class="panel p-6"><h2 class="text-lg font-bold">جلسات العمل</h2><div class="mt-4 space-y-3"><?php $__empty_1 = true; $__currentLoopData = $driver->workSessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><div class="flex justify-between rounded-xl border p-3"><span><?php echo e($session->started_at?->format('Y-m-d H:i')); ?></span><span><?php echo e($session->status); ?></span></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><p class="text-slate-500">لا توجد جلسات عمل.</p><?php endif; ?></div></div></div></div> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\HP\Downloads\al-khawaja-final-v2-full\al-khawaja-delivery-full\resources\views/drivers/show.blade.php ENDPATH**/ ?>