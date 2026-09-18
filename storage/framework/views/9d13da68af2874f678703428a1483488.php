<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><div class="dashboard-shell px-4 py-6 md:px-8"><div class="mx-auto max-w-2xl panel p-6"><h1 class="text-2xl font-bold">إضافة سائق</h1><form method="POST" action="<?php echo e(route('drivers.store')); ?>" class="mt-6 grid gap-4 md:grid-cols-2"><?php echo csrf_field(); ?><label class="text-sm font-semibold">الاسم<input name="name" required class="mt-2 w-full rounded-xl border-slate-200"></label><label class="text-sm font-semibold">الهاتف<input name="phone" required class="mt-2 w-full rounded-xl border-slate-200"></label><label class="text-sm font-semibold">رقم الرخصة<input name="license_number" class="mt-2 w-full rounded-xl border-slate-200"></label><label class="text-sm font-semibold">نوع المركبة<input name="vehicle_type" value="car" class="mt-2 w-full rounded-xl border-slate-200"></label><label class="text-sm font-semibold">لوحة المركبة<input name="vehicle_plate" class="mt-2 w-full rounded-xl border-slate-200"></label><div class="md:col-span-2"><button class="rounded-xl bg-slate-900 px-5 py-3 font-semibold text-white">حفظ السائق</button></div></form></div></div> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\HP\Downloads\al-khawaja-final-v2-full\al-khawaja-delivery-full\resources\views/drivers/create.blade.php ENDPATH**/ ?>