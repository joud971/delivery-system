<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php $__env->startSection('page_title','إضافة حساب'); ?><div class="mx-auto max-w-3xl"><div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"><div class="mb-6"><div class="text-sm text-orange-500">حساب جديد</div><h1 class="text-2xl font-black">إضافة مستخدم</h1></div><form method="POST" action="<?php echo e(route('users.store')); ?>" class="grid gap-5 md:grid-cols-2"><?php echo csrf_field(); ?><label class="text-sm font-bold">الاسم<input name="name" required class="mt-2 w-full rounded-xl border-slate-200"></label><label class="text-sm font-bold">اسم المستخدم<input name="username" required class="mt-2 w-full rounded-xl border-slate-200"></label><label class="text-sm font-bold">البريد الإلكتروني<input name="email" type="email" required class="mt-2 w-full rounded-xl border-slate-200"></label><label class="text-sm font-bold">الهاتف<input name="phone" class="mt-2 w-full rounded-xl border-slate-200"></label><label class="text-sm font-bold">الدور<select name="role" required class="mt-2 w-full rounded-xl border-slate-200"><?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($role->name); ?>"><?php echo e($role->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label><div></div><label class="text-sm font-bold">كلمة المرور<input name="password" type="password" required minlength="8" class="mt-2 w-full rounded-xl border-slate-200"></label><label class="text-sm font-bold">تأكيد كلمة المرور<input name="password_confirmation" type="password" required minlength="8" class="mt-2 w-full rounded-xl border-slate-200"></label><div class="md:col-span-2 flex gap-3"><button class="rounded-xl bg-orange-500 px-5 py-3 font-black text-white">إنشاء الحساب</button><a href="<?php echo e(route('users.index')); ?>" class="rounded-xl border border-slate-200 px-5 py-3 font-bold">إلغاء</a></div></form></div></div> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\HP\Downloads\al-khawaja-final-v2-full\al-khawaja-delivery-full\resources\views/users/create.blade.php ENDPATH**/ ?>