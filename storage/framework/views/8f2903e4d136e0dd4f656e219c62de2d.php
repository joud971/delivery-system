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
<?php $__env->startSection('page_title','الملف الشخصي'); ?>
<div class="mx-auto max-w-4xl space-y-5"><div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"><div class="mb-6"><div class="text-sm text-orange-500">الحساب</div><h1 class="text-2xl font-black">الملف الشخصي</h1></div><form method="POST" action="<?php echo e(route('profile.update')); ?>" class="grid gap-5 md:grid-cols-2"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><label class="text-sm font-bold">الاسم<input name="name" value="<?php echo e(old('name',$user->name)); ?>" required class="mt-2 w-full rounded-xl border-slate-200"></label><label class="text-sm font-bold">البريد الإلكتروني<input name="email" type="email" value="<?php echo e(old('email',$user->email)); ?>" required class="mt-2 w-full rounded-xl border-slate-200"></label><div><div class="text-xs text-slate-400">اسم المستخدم</div><div class="mt-2 rounded-xl bg-slate-50 px-4 py-3 font-bold"><?php echo e($user->username); ?></div></div><div><div class="text-xs text-slate-400">الدور</div><div class="mt-2 rounded-xl bg-slate-50 px-4 py-3 font-bold"><?php echo e($user->getRoleNames()->join('، ')); ?></div></div><div class="md:col-span-2"><button class="rounded-xl bg-orange-500 px-5 py-3 font-black text-white">حفظ البيانات</button></div></form></div>
<div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"><h2 class="text-lg font-black">تغيير كلمة المرور</h2><form method="POST" action="<?php echo e(route('password.update')); ?>" class="mt-5 grid gap-5 md:grid-cols-3"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?><label class="text-sm font-bold">كلمة المرور الحالية<input name="current_password" type="password" required class="mt-2 w-full rounded-xl border-slate-200"></label><label class="text-sm font-bold">كلمة المرور الجديدة<input name="password" type="password" minlength="8" required class="mt-2 w-full rounded-xl border-slate-200"></label><label class="text-sm font-bold">تأكيد الجديدة<input name="password_confirmation" type="password" minlength="8" required class="mt-2 w-full rounded-xl border-slate-200"></label><div class="md:col-span-3"><button class="rounded-xl bg-slate-950 px-5 py-3 font-black text-white">تحديث كلمة المرور</button></div></form></div></div> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\HP\Downloads\al-khawaja-final-v2-full\al-khawaja-delivery-full\resources\views/profile/edit.blade.php ENDPATH**/ ?>