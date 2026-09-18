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
<?php $__env->startSection('page_title','إدارة الطلبات'); ?>
<div class="mx-auto max-w-7xl space-y-5" x-data="assignOrderModal()">
    <div class="rounded-3xl bg-gradient-to-l from-slate-950 via-slate-900 to-orange-700 p-6 text-white shadow-xl md:p-8">
        <div class="flex flex-col justify-between gap-5 lg:flex-row lg:items-end">
            <div>
                <div class="text-sm font-semibold text-orange-200">مركز التشغيل</div>
                <h1 class="mt-2 text-3xl font-black">إدارة الطلبات</h1>
                <p class="mt-2 max-w-2xl text-sm leading-7 text-white/70">تابع الطلبات، راقب حالتها، وأرسل كل طلب مباشرة إلى السائق المناسب.</p>
            </div>
            <a href="<?php echo e(route('orders.create')); ?>" class="rounded-2xl bg-white px-5 py-3 text-sm font-black text-slate-950 shadow-lg">＋ إرسال طلب جديد</a>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <?php ($quickStats = [
            ['label'=>'إجمالي النتائج الحالية','value'=>$orders->total(),'bg'=>'bg-sky-50','text'=>'text-sky-700'],
            ['label'=>'طلبات جديدة','value'=>\App\Models\Order::where('status','new')->count(),'bg'=>'bg-orange-50','text'=>'text-orange-700'],
            ['label'=>'قيد التوصيل','value'=>\App\Models\Order::where('status','in_transit')->count(),'bg'=>'bg-violet-50','text'=>'text-violet-700'],
            ['label'=>'تم التسليم','value'=>\App\Models\Order::where('status','delivered')->count(),'bg'=>'bg-emerald-50','text'=>'text-emerald-700'],
        ]); ?>
        <?php $__currentLoopData = $quickStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
                <div class="flex items-center justify-between"><span class="text-sm font-bold text-slate-500"><?php echo e($stat['label']); ?></span><span class="grid h-10 w-10 place-items-center rounded-xl <?php echo e($stat['bg']); ?> <?php echo e($stat['text']); ?>">●</span></div>
                <div class="mt-3 text-3xl font-black"><?php echo e(number_format($stat['value'])); ?></div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
        <form class="grid gap-3 lg:grid-cols-[1.6fr_1fr_1fr_1fr_auto]">
            <input name="q" value="<?php echo e(request('q')); ?>" placeholder="رقم الطلب أو اسم العميل أو الهاتف" class="rounded-2xl border-slate-200">
            <select name="status" class="rounded-2xl border-slate-200"><option value="">كل الحالات</option><?php $__currentLoopData = \App\Models\Order::STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($key); ?>" <?php if(request('status')===$key): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
            <select name="driver_id" class="rounded-2xl border-slate-200"><option value="">كل السائقين</option><?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($driver->id); ?>" <?php if((string)request('driver_id')===(string)$driver->id): echo 'selected'; endif; ?>><?php echo e($driver->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
            <select name="district_id" class="rounded-2xl border-slate-200"><option value="">كل المناطق</option><?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $district): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($district->id); ?>" <?php if((string)request('district_id')===(string)$district->id): echo 'selected'; endif; ?>><?php echo e($district->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
            <div class="flex gap-2"><button class="flex-1 rounded-2xl bg-slate-950 px-5 py-2.5 font-bold text-white">تطبيق</button><a href="<?php echo e(route('orders.index')); ?>" class="grid min-w-16 place-items-center rounded-2xl border border-slate-200">مسح</a></div>
        </form>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-right text-sm">
                <thead class="bg-slate-950 text-white"><tr><th class="px-5 py-4">الطلب</th><th class="px-5 py-4">العميل</th><th class="px-5 py-4">السائق</th><th class="px-5 py-4">المنطقة</th><th class="px-5 py-4">أجرة التوصيل</th><th class="px-5 py-4">الأولوية</th><th class="px-5 py-4">الحالة</th><th class="px-5 py-4">الإجراء</th></tr></thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-b border-slate-100 transition hover:bg-orange-50/30">
                        <td class="px-5 py-4"><a href="<?php echo e(route('orders.show',$order)); ?>" class="font-black text-slate-900 hover:text-orange-600"><?php echo e($order->order_number); ?></a><div class="text-xs text-slate-400"><?php echo e($order->created_at?->format('Y-m-d H:i')); ?></div></td>
                        <td class="px-5 py-4"><div class="font-bold"><?php echo e($order->customer_name_snapshot ?: $order->customer?->name); ?></div><div class="text-xs text-slate-400"><?php echo e($order->customer_phone_snapshot ?: $order->customer?->phone); ?></div></td>
                        <td class="px-5 py-4"><span class="inline-flex rounded-full <?php echo e($order->driver ? 'bg-violet-50 text-violet-700' : 'bg-slate-100 text-slate-500'); ?> px-3 py-1.5 text-xs font-bold"><?php echo e($order->driver?->name ?? 'غير مسند'); ?></span></td>
                        <td class="px-5 py-4 text-slate-600"><?php echo e($order->district?->name); ?></td>
                        <td class="px-5 py-4 font-black"><?php echo e(number_format($order->delivery_fee,0)); ?> ل.س</td>
                        <td class="px-5 py-4"><span class="rounded-full <?php echo e($order->priority === 'urgent' ? 'bg-rose-50 text-rose-700' : 'bg-sky-50 text-sky-700'); ?> px-3 py-1.5 text-xs font-bold"><?php echo e($order->priorityLabel()); ?></span></td>
                        <td class="px-5 py-4"><span class="rounded-full <?php echo e(['delivered'=>'bg-emerald-50 text-emerald-700','cancelled'=>'bg-rose-50 text-rose-700','in_transit'=>'bg-blue-50 text-blue-700','assigned'=>'bg-violet-50 text-violet-700','confirmed'=>'bg-amber-50 text-amber-700'][$order->status] ?? 'bg-slate-100 text-slate-700'); ?> px-3 py-1.5 text-xs font-bold"><?php echo e($order->statusLabel()); ?></span></td>
                        <td class="px-5 py-4">
                            <div class="flex flex-wrap gap-2">
                                <a href="<?php echo e(route('orders.show',$order)); ?>" class="rounded-xl bg-slate-100 px-3 py-2 text-xs font-bold">عرض</a>
                                <?php if(!in_array($order->status,['delivered','cancelled'],true)): ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('assign-orders')): ?>
                                        <button type="button" @click="openAssign(<?php echo \Illuminate\Support\Js::from($order->id)->toHtml() ?>, <?php echo \Illuminate\Support\Js::from($order->order_number)->toHtml() ?>, <?php echo \Illuminate\Support\Js::from(route('orders.assign',$order))->toHtml() ?>)" class="rounded-xl bg-orange-500 px-3 py-2 text-xs font-bold text-white shadow-md shadow-orange-500/10">إرسال للسائق</button>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update',$order)): ?><a href="<?php echo e(route('orders.edit',$order)); ?>" class="rounded-xl bg-orange-50 px-3 py-2 text-xs font-bold text-orange-700">تعديل</a><?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="8" class="py-16 text-center text-slate-400">لا توجد نتائج مطابقة.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 p-5"><?php echo e($orders->links()); ?></div>
    </div>

    <div x-show="open" x-cloak class="fixed inset-0 z-[70] grid place-items-center bg-slate-950/60 p-4 backdrop-blur-sm">
        <div @click.outside="open=false" class="w-full max-w-2xl rounded-3xl bg-white shadow-2xl">
            <div class="flex items-center justify-between border-b border-slate-100 p-5"><div><div class="text-xs font-bold text-orange-500">إسناد الطلب</div><h2 class="mt-1 text-xl font-black" x-text="selectedOrder"></h2></div><button @click="open=false" class="grid h-10 w-10 place-items-center rounded-xl bg-slate-100">×</button></div>
            <form method="POST" :action="assignAction" class="p-5">
                <?php echo csrf_field(); ?>
                <p class="mb-4 text-sm text-slate-500">اختر أحد السائقين الموجودين على رأس العمل. ستشاهد آخر منطقة أنهى فيها كل سائق طلبًا.</p>
                <div class="grid max-h-[55vh] gap-3 overflow-y-auto">
                    <?php $__empty_1 = true; $__currentLoopData = $workingDrivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <label class="group flex cursor-pointer items-center justify-between gap-4 rounded-2xl border border-slate-200 p-4 transition hover:border-orange-300 hover:bg-orange-50/40">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="driver_id" value="<?php echo e($driver->id); ?>" x-model="selectedDriver" class="h-5 w-5 text-orange-500">
                                <div class="grid h-11 w-11 place-items-center rounded-2xl bg-slate-950 text-sm font-black text-white"><?php echo e(mb_substr($driver->name,0,1)); ?></div>
                                <div><div class="font-black"><?php echo e($driver->name); ?></div><div class="mt-1 text-xs text-slate-400">آخر منطقة: <span class="font-bold text-slate-600"><?php echo e($driver->last_completed_area ?? 'لا يوجد طلب مكتمل'); ?></span></div></div>
                            </div>
                            <div class="text-left"><span class="rounded-full <?php echo e($driver->is_available ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700'); ?> px-3 py-1.5 text-[11px] font-black"><?php echo e($driver->is_available ? 'متاح الآن' : 'مشغول'); ?></span><div class="mt-2 text-xs text-slate-400"><?php echo e($driver->current_orders_count); ?> طلب حالي</div></div>
                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="rounded-2xl border border-dashed border-slate-300 p-8 text-center text-sm text-slate-500">لا يوجد سائقون على رأس العمل حاليًا.</div>
                    <?php endif; ?>
                </div>
                <div class="mt-5 flex justify-end gap-3"><button type="button" @click="open=false" class="rounded-2xl border border-slate-200 px-5 py-3 text-sm font-bold">إلغاء</button><button :disabled="!selectedDriver" class="rounded-2xl bg-orange-500 px-6 py-3 text-sm font-black text-white disabled:cursor-not-allowed disabled:opacity-40">إرسال الطلب</button></div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function assignOrderModal() {
    return {
        open: false,
        selectedOrder: '',
        selectedDriver: '',
        assignAction: '',
        openAssign(id, number, action) {
            this.open = true;
            this.selectedOrder = number;
            this.selectedDriver = '';
            this.assignAction = action;
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
<?php /**PATH C:\Users\HP\Downloads\al-khawaja-final-v2-full\al-khawaja-delivery-full\resources\views/orders/index.blade.php ENDPATH**/ ?>