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
<?php $__env->startSection('page_title','طلبات السائق'); ?>
<div class="mx-auto max-w-6xl space-y-5" x-data="driverPortal(<?php echo e($unreadCount); ?>)">
    <div class="rounded-3xl bg-gradient-to-l from-slate-950 via-slate-900 to-orange-700 p-6 text-white shadow-xl md:p-8">
        <div class="flex flex-col justify-between gap-5 md:flex-row md:items-end">
            <div><div class="text-sm font-semibold text-orange-200">مساحة السائق</div><h1 class="mt-2 text-3xl font-black">مرحبًا، <?php echo e($driver->name); ?> 👋</h1><p class="mt-2 text-sm leading-7 text-white/70">من هنا ترى الطلبات المسندة إليك، تقبل الطلب وتتابع عملية التوصيل حتى التسليم.</p></div>
            <div class="rounded-2xl bg-white/10 px-5 py-4 backdrop-blur"><div class="text-xs text-white/60">حالتك الحالية</div><div class="mt-1 font-black"><?php echo e($driver->is_available ? 'متاح للعمل' : 'مشغول / خارج التوفر'); ?></div></div>
        </div>
    </div>

    <div x-show="newAlert" x-cloak class="rounded-2xl border border-orange-200 bg-orange-50 px-5 py-4 text-sm font-bold text-orange-900 shadow-sm"><span x-text="alertMessage"></span></div>

    <?php ($openSession = $driver->workSessions()->where('status','open')->latest('started_at')->first()); ?>
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><div class="text-sm font-bold text-slate-500">طلباتك الحالية</div><div class="mt-2 text-3xl font-black"><?php echo e($orders->count()); ?></div></div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><div class="text-sm font-bold text-slate-500">طلبات بانتظار القبول</div><div class="mt-2 text-3xl font-black text-orange-600"><?php echo e($orders->where('status','assigned')->count()); ?></div></div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><div class="text-sm font-bold text-slate-500">آخر منطقة مكتملة</div><div class="mt-2 text-lg font-black"><?php echo e($lastCompletedOrder?->district?->name ?? 'لا يوجد'); ?></div></div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><div class="text-sm font-bold text-slate-500">الدوام</div><div class="mt-2 text-lg font-black"><?php echo e($openSession ? 'مسجل الآن' : 'غير مسجل'); ?></div></div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm md:p-7">
        <div class="mb-5 flex flex-col justify-between gap-3 md:flex-row md:items-center"><div><h2 class="text-xl font-black">طلباتك</h2><p class="mt-1 text-sm text-slate-400">أي طلب جديد يتم إسناده إليك يظهر هنا ويصلك إشعار.</p></div><div class="flex gap-2"><?php if(!$openSession): ?><form method="POST" action="<?php echo e(route('driver.work.start')); ?>"><?php echo csrf_field(); ?><button class="rounded-2xl bg-emerald-500 px-4 py-2.5 text-sm font-black text-white">بدء الدوام</button></form><?php else: ?><form method="POST" action="<?php echo e(route('driver.work.end')); ?>"><?php echo csrf_field(); ?><button class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-2.5 text-sm font-black text-rose-700">إنهاء الدوام</button></form><?php endif; ?></div></div>

        <div class="space-y-4">
            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="rounded-3xl border border-slate-200 p-5 transition hover:-translate-y-0.5 hover:shadow-lg">
                    <div class="flex flex-col justify-between gap-4 lg:flex-row lg:items-center">
                        <div class="flex items-start gap-4"><div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-slate-950 text-sm font-black text-white"><?php echo e($order->priority === 'urgent' ? '!' : '✓'); ?></div><div><div class="flex flex-wrap items-center gap-2"><span class="font-black"><?php echo e($order->order_number); ?></span><span class="rounded-full <?php echo e($order->priority === 'urgent' ? 'bg-rose-50 text-rose-700' : 'bg-sky-50 text-sky-700'); ?> px-3 py-1 text-[11px] font-black"><?php echo e($order->priorityLabel()); ?></span></div><div class="mt-2 text-sm text-slate-500"><?php echo e($order->customer_name_snapshot); ?> · <?php echo e($order->customer_phone_snapshot); ?></div><div class="mt-1 text-xs text-slate-400"><?php echo e($order->district?->name); ?> · <?php echo e($order->address_snapshot ?: 'العنوان غير محدد'); ?></div></div></div>
                        <div class="flex flex-wrap gap-2"><?php if($order->status === 'assigned'): ?><form method="POST" action="<?php echo e(route('driver.orders.accept',$order)); ?>"><?php echo csrf_field(); ?><button class="rounded-2xl bg-orange-500 px-5 py-2.5 text-sm font-black text-white">قبول الطلب</button></form><?php elseif($order->status === 'confirmed'): ?><form method="POST" action="<?php echo e(route('driver.orders.start',$order)); ?>"><?php echo csrf_field(); ?><button class="rounded-2xl bg-sky-600 px-5 py-2.5 text-sm font-black text-white">بدء التوصيل</button></form><?php elseif($order->status === 'in_transit'): ?><form method="POST" action="<?php echo e(route('driver.orders.complete',$order)); ?>"><?php echo csrf_field(); ?><button class="rounded-2xl bg-emerald-600 px-5 py-2.5 text-sm font-black text-white">تم التسليم</button></form><?php endif; ?><a href="<?php echo e(route('driver.orders.show',$order)); ?>" class="rounded-2xl border border-slate-200 px-5 py-2.5 text-sm font-black">تفاصيل الطلب</a></div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-12 text-center"><div class="text-4xl">✓</div><h3 class="mt-3 text-lg font-black">لا توجد طلبات حالية</h3><p class="mt-1 text-sm text-slate-500">عندما يتم إسناد طلب إليك سيظهر هنا ويصلك إشعار.</p></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm md:p-7">
        <div class="mb-5 flex items-center justify-between"><div><h2 class="text-xl font-black">آخر الإشعارات</h2><p class="mt-1 text-sm text-slate-400">تنبيهات الطلبات والعمليات الخاصة بك.</p></div><a href="<?php echo e(route('notifications.index')); ?>" class="text-sm font-bold text-orange-600">عرض الكل</a></div>
        <div class="space-y-3"><?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><a href="<?php echo e($notification->related_id && $notification->related_model === \App\Models\Order::class ? route('driver.orders.show',$notification->related_id) : route('notifications.show',$notification)); ?>" class="block rounded-2xl <?php echo e($notification->is_read ? 'bg-slate-50' : 'bg-orange-50'); ?> p-4"><div class="flex justify-between gap-4"><div><div class="font-black"><?php echo e($notification->title); ?></div><div class="mt-1 text-sm text-slate-500"><?php echo e($notification->message); ?></div></div><div class="shrink-0 text-xs text-slate-400"><?php echo e($notification->created_at?->diffForHumans()); ?></div></div></a><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><p class="text-sm text-slate-400">لا توجد إشعارات بعد.</p><?php endif; ?></div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function driverPortal(initialCount) {
    return {
        unreadCount: initialCount,
        lastId: null,
        newAlert: false,
        alertMessage: '',
        async checkNotifications() {
            try {
                const response = await fetch(<?php echo json_encode(route('driver.notifications.unread'), 15, 512) ?>, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
                const data = await response.json();
                if (data.latest && this.lastId !== null && data.latest.id > this.lastId) {
                    this.newAlert = true;
                    this.alertMessage = `${data.latest.title}: ${data.latest.message}`;
                    if ('Notification' in window && Notification.permission === 'granted') {
                        new Notification(data.latest.title, { body: data.latest.message });
                    }
                }
                this.lastId = data.latest?.id ?? this.lastId;
                this.unreadCount = data.count;
            } catch (error) {}
        },
        init() {
            this.checkNotifications();
            setInterval(() => this.checkNotifications(), 8000);
        }
    };
}
</script>
<?php $__env->stopPush(); ?>
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
<?php /**PATH C:\Users\HP\Downloads\al-khawaja-final-v2-full\al-khawaja-delivery-full\resources\views/driver/portal.blade.php ENDPATH**/ ?>