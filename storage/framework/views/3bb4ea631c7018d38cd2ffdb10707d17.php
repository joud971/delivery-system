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
<?php $__env->startSection('page_title','تعديل الطلب'); ?>
<div class="mx-auto max-w-5xl space-y-5">
    <div class="rounded-3xl bg-gradient-to-l from-slate-950 via-slate-900 to-orange-700 p-6 text-white shadow-xl md:p-8"><div class="text-sm font-semibold text-orange-200"><?php echo e($order->order_number); ?></div><h1 class="mt-2 text-3xl font-black">تعديل الطلب</h1><p class="mt-2 text-sm text-white/70">تعديل الحالة، الإسناد والملاحظات التشغيلية.</p></div>
    <form method="POST" action="<?php echo e(route('orders.update',$order)); ?>" class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
        <div class="grid gap-5 md:grid-cols-2">
            <label class="text-sm font-bold">المنطقة<select name="district_id" class="mt-2 w-full rounded-2xl border-slate-200"><option value="">بدون تغيير</option><?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $district): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($district->id); ?>" <?php if($order->district_id===$district->id): echo 'selected'; endif; ?>><?php echo e($district->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label class="text-sm font-bold">السائق<select name="driver_id" class="mt-2 w-full rounded-2xl border-slate-200"><option value="">غير مسند</option><?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($driver->id); ?>" <?php if($order->driver_id===$driver->id): echo 'selected'; endif; ?>><?php echo e($driver->name); ?><?php echo e($driver->is_available ? ' — متاح' : ' — مشغول'); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label class="text-sm font-bold">الحالة<select name="status" class="mt-2 w-full rounded-2xl border-slate-200"><option value="">بدون تغيير</option><?php $__currentLoopData = \App\Models\Order::STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($key); ?>" <?php if($order->status===$key): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label class="text-sm font-bold">حالة الدفع<select name="payment_status" class="mt-2 w-full rounded-2xl border-slate-200"><?php $__currentLoopData = \App\Models\Order::PAYMENT_STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($key); ?>" <?php if($order->payment_status===$key): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label class="text-sm font-bold">الأولوية<select name="priority" class="mt-2 w-full rounded-2xl border-slate-200"><option value="normal" <?php if($order->priority==='normal'): echo 'selected'; endif; ?>>عادي</option><option value="urgent" <?php if($order->priority==='urgent'): echo 'selected'; endif; ?>>مستعجل</option></select></label>
            <div class="rounded-2xl bg-slate-50 p-4"><div class="text-xs text-slate-400">أجرة التوصيل</div><div class="mt-1 text-xl font-black"><?php echo e(number_format($order->delivery_fee,0)); ?> ل.س</div><div class="mt-1 text-xs text-slate-400">طريقة الدفع: <?php echo e($order->paymentMethodLabel()); ?></div></div>
            <label class="text-sm font-bold md:col-span-2">ملاحظات للموصل<textarea name="driver_notes" rows="3" class="mt-2 w-full rounded-2xl border-slate-200"><?php echo e(old('driver_notes',$order->driver_notes)); ?></textarea></label>
            <label class="text-sm font-bold md:col-span-2">ملاحظات عامة<textarea name="notes" rows="3" class="mt-2 w-full rounded-2xl border-slate-200"><?php echo e(old('notes',$order->notes)); ?></textarea></label>
            <label class="text-sm font-bold md:col-span-2">ملاحظة تغيير الحالة<textarea name="transition_note" rows="2" class="mt-2 w-full rounded-2xl border-slate-200" placeholder="سبب تغيير الحالة أو ملاحظة داخلية..."></textarea></label>
        </div>
        <div class="mt-6 flex gap-3"><button class="rounded-2xl bg-slate-950 px-5 py-3 text-sm font-black text-white">حفظ التعديلات</button><a href="<?php echo e(route('orders.show',$order)); ?>" class="rounded-2xl border border-slate-200 px-5 py-3 text-sm font-bold">إلغاء</a></div>
    </form>
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
<?php /**PATH C:\Users\HP\Downloads\al-khawaja-final-v2-full\al-khawaja-delivery-full\resources\views/orders/edit.blade.php ENDPATH**/ ?>