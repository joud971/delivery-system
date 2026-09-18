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
<?php $__env->startSection('page_title','الإشعارات'); ?>
<div class="mx-auto max-w-6xl"><div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"><div class="mb-5 flex flex-col justify-between gap-3 sm:flex-row sm:items-center"><div><div class="text-sm text-orange-500">المركز</div><h1 class="text-2xl font-black">الإشعارات</h1><p class="mt-1 text-sm text-slate-500">عدد غير المقروء: <?php echo e($unreadCount); ?></p></div><?php if($unreadCount): ?><form method="POST" action="<?php echo e(route('notifications.mark-all-read')); ?>"><?php echo csrf_field(); ?><button class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold">تحديد الكل كمقروء</button></form><?php endif; ?></div><div class="space-y-3"><?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><a href="<?php echo e(route('notifications.show',$notification)); ?>" class="flex items-center justify-between gap-4 rounded-2xl border border-slate-200 p-4 transition hover:border-orange-200 hover:bg-orange-50/30"><div class="min-w-0"><div class="flex items-center gap-2"><span class="font-bold"><?php echo e($notification->title); ?></span><?php if(!$notification->is_read): ?><span class="rounded-full bg-orange-50 px-2 py-0.5 text-[10px] font-bold text-orange-700">جديد</span><?php endif; ?></div><p class="mt-1 truncate text-sm text-slate-500"><?php echo e($notification->message); ?></p></div><div class="shrink-0 text-xs text-slate-400"><?php echo e($notification->created_at?->diffForHumans()); ?></div></a><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><p class="py-14 text-center text-slate-400">لا توجد إشعارات.</p><?php endif; ?></div><div class="mt-5"><?php echo e($notifications->links()); ?></div></div></div> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\HP\Downloads\al-khawaja-final-v2-full\al-khawaja-delivery-full\resources\views/notifications/index.blade.php ENDPATH**/ ?>