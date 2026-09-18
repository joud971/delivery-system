<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php $__env->startSection('page_title','الحسابات والمستخدمون'); ?><div class="mx-auto max-w-6xl space-y-5"><div class="flex items-end justify-between"><div><div class="text-sm text-orange-500">الإدارة</div><h1 class="text-2xl font-black">الحسابات والمستخدمون</h1><p class="mt-1 text-sm text-slate-500">إدارة الموظفين والأدوار وصلاحيات الوصول.</p></div><a href="<?php echo e(route('users.create')); ?>" class="rounded-xl bg-slate-950 px-4 py-2.5 text-sm font-bold text-white">＋ إضافة حساب</a></div><div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><table class="min-w-full text-right text-sm"><thead><tr class="border-b text-slate-400"><th class="pb-3">المستخدم</th><th class="pb-3">اسم المستخدم</th><th class="pb-3">الدور</th><th class="pb-3">الهاتف</th><th class="pb-3">إجراء</th></tr></thead><tbody><?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><tr class="border-b"><td class="py-4"><div class="font-bold"><?php echo e($user->name); ?></div><div class="text-xs text-slate-400"><?php echo e($user->email); ?></div></td><td class="py-4 font-semibold"><?php echo e($user->username); ?></td><td class="py-4"><?php echo e($user->getRoleNames()->join('، ')); ?></td><td class="py-4"><?php echo e($user->phone ?: '—'); ?></td><td class="py-4"><?php if(!$user->is(auth()->user())): ?><form method="POST" action="<?php echo e(route('users.destroy',$user)); ?>" onsubmit="return confirm('حذف هذا الحساب؟')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="rounded-lg bg-rose-50 px-3 py-1.5 text-xs font-bold text-rose-700">حذف</button></form><?php else: ?><span class="text-xs text-slate-400">حسابك</span><?php endif; ?></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></tbody></table><div class="mt-5"><?php echo e($users->links()); ?></div></div></div> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\HP\Downloads\al-khawaja-final-v2-full\al-khawaja-delivery-full\resources\views/users/index.blade.php ENDPATH**/ ?>