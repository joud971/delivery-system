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
<?php $__env->startSection('page_title','تفاصيل الطلب'); ?>
<div class="mx-auto max-w-5xl space-y-5">
    <div class="rounded-3xl bg-gradient-to-l from-slate-950 via-slate-900 to-orange-700 p-6 text-white shadow-xl md:p-8"><div class="text-sm font-semibold text-orange-200">طلب مسند إليك</div><h1 class="mt-2 text-3xl font-black"><?php echo e($order->order_number); ?></h1><p class="mt-2 text-sm text-white/70">راجع العنوان والتفاصيل قبل قبول الطلب والبدء بالتوصيل.</p></div>
    <div class="grid gap-5 lg:grid-cols-[1.2fr_0.8fr]">
        <div class="space-y-5">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm"><div class="flex items-center justify-between"><h2 class="text-xl font-black">بيانات العميل</h2><span class="rounded-full <?php echo e($order->priority === 'urgent' ? 'bg-rose-50 text-rose-700' : 'bg-sky-50 text-sky-700'); ?> px-3 py-1.5 text-xs font-black"><?php echo e($order->priorityLabel()); ?></span></div><div class="mt-5 grid gap-4 sm:grid-cols-2"><div class="rounded-2xl bg-slate-50 p-4"><div class="text-xs text-slate-400">الاسم</div><div class="mt-1 font-black"><?php echo e($order->customer_name_snapshot); ?></div></div><div class="rounded-2xl bg-slate-50 p-4"><div class="text-xs text-slate-400">الهاتف</div><div class="mt-1 font-black"><?php echo e($order->customer_phone_snapshot); ?></div></div><div class="rounded-2xl bg-orange-50 p-4 sm:col-span-2"><div class="text-xs text-orange-500">عنوان التسليم</div><div class="mt-1 font-black leading-7"><?php echo e($order->address_snapshot ?: $order->customer?->address ?: 'غير محدد'); ?></div></div></div></div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm"><h2 class="text-xl font-black">تفاصيل الطلب</h2><p class="mt-4 whitespace-pre-line leading-8 text-slate-600"><?php echo e($order->order_details); ?></p><?php if($order->driver_notes): ?><div class="mt-5 rounded-2xl border border-orange-100 bg-orange-50 p-4"><div class="text-xs font-bold text-orange-600">ملاحظات للموصل</div><div class="mt-1 whitespace-pre-line text-sm leading-7 text-orange-950"><?php echo e($order->driver_notes); ?></div></div><?php endif; ?></div>
        </div>
        <div class="space-y-5">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm"><div class="text-xs text-slate-400">الحالة الحالية</div><div class="mt-2 text-2xl font-black"><?php echo e($order->statusLabel()); ?></div><div class="mt-4 text-sm text-slate-500">المنطقة: <span class="font-bold text-slate-900"><?php echo e($order->district?->name); ?></span></div><div class="mt-2 text-sm text-slate-500">أجرة التوصيل: <span class="font-black text-slate-900"><?php echo e(number_format($order->delivery_fee,0)); ?> ل.س</span></div></div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm"><?php if($order->status === 'assigned'): ?><form method="POST" action="<?php echo e(route('driver.orders.accept',$order)); ?>"><?php echo csrf_field(); ?><button class="w-full rounded-2xl bg-orange-500 px-5 py-3 font-black text-white">قبول الطلب</button></form><?php elseif($order->status === 'confirmed'): ?><form method="POST" action="<?php echo e(route('driver.orders.start',$order)); ?>"><?php echo csrf_field(); ?><button class="w-full rounded-2xl bg-sky-600 px-5 py-3 font-black text-white">بدء التوصيل</button></form><?php elseif($order->status === 'in_transit'): ?><form method="POST" action="<?php echo e(route('driver.orders.complete',$order)); ?>"><?php echo csrf_field(); ?><button class="w-full rounded-2xl bg-emerald-600 px-5 py-3 font-black text-white">تأكيد التسليم</button></form><?php else: ?><div class="rounded-2xl bg-slate-50 p-4 text-center text-sm font-bold text-slate-500">لا يوجد إجراء متاح حاليًا.</div><?php endif; ?></div>
        </div>
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
<?php /**PATH C:\Users\HP\Downloads\al-khawaja-final-v2-full\al-khawaja-delivery-full\resources\views/driver/order.blade.php ENDPATH**/ ?>