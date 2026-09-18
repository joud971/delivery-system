<?php

use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\DriverPortalController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/driver', [DriverPortalController::class, 'index'])->name('driver.portal');
    Route::get('/driver/orders/{order}', [DriverPortalController::class, 'showOrder'])->name('driver.orders.show');
    Route::post('/driver/orders/{order}/accept', [DriverPortalController::class, 'acceptOrder'])->name('driver.orders.accept');
    Route::post('/driver/orders/{order}/start', [DriverPortalController::class, 'startDelivery'])->name('driver.orders.start');
    Route::post('/driver/orders/{order}/complete', [DriverPortalController::class, 'completeDelivery'])->name('driver.orders.complete');
    Route::post('/driver/work/start', [DriverPortalController::class, 'startWork'])->name('driver.work.start');
    Route::post('/driver/work/end', [DriverPortalController::class, 'endWork'])->name('driver.work.end');
    Route::get('/driver/notifications/unread', [DriverPortalController::class, 'unreadNotifications'])->name('driver.notifications.unread');

    Route::get('/orders/customer-lookup', [OrderController::class, 'customerLookup'])->name('orders.customer-lookup');
    Route::post('/orders/{order}/assign', [OrderController::class, 'assignDriver'])->name('orders.assign');
    Route::resource('orders', OrderController::class);

    Route::resource('customers', CustomerController::class);
    Route::resource('drivers', DriverController::class);

    Route::resource('notifications', NotificationController::class)->only(['index', 'show', 'update']);
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');

    Route::resource('reports', ReportController::class)->only(['index']);
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');

    Route::get('/finance', [FinanceController::class, 'index'])->name('finance.index');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::post('/orders/{order}/payments', [PaymentController::class, 'store'])->name('orders.payments.store');

    Route::resource('settings', SettingController::class)->only(['index', 'store']);
    Route::get('/districts', [DistrictController::class, 'index'])->name('districts.index');
    Route::post('/districts', [DistrictController::class, 'store'])->name('districts.store');
    Route::patch('/districts/{district}', [DistrictController::class, 'update'])->name('districts.update');
    Route::delete('/districts/{district}', [DistrictController::class, 'destroy'])->name('districts.destroy');

    Route::resource('users', UserController::class)->except(['show', 'edit', 'update']);
    Route::get('/search', SearchController::class)->name('search');
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
