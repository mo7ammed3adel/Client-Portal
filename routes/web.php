<?php

use App\Http\Controllers\Admin\ContactRequestController as AdminContactController;
use App\Http\Controllers\Admin\CourierController as AdminCourierController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Courier\CourierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Webhooks\KashierWebhookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public website (no account required)
|--------------------------------------------------------------------------
*/
Route::get('/', HomeController::class)->name('home');
Route::get('/pricing', PricingController::class)->name('pricing');
Route::get('/about', AboutController::class)->name('about');
Route::get('/policies', \App\Http\Controllers\PoliciesController::class)->name('policies');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Public delivery order creation + payment
Route::get('/create-order', [OrderController::class, 'create'])->name('order.create');
Route::post('/orders', [OrderController::class, 'store'])->name('order.store');
Route::post('/orders/{order}/retry-payment', [OrderController::class, 'retryPayment'])->name('order.retry');
Route::get('/payment/success/{orderNumber}', [OrderController::class, 'success'])->name('order.success');
Route::get('/payment/failed', [OrderController::class, 'failed'])->name('order.failed');

// Public shipment tracking
Route::get('/track', [OrderController::class, 'track'])->name('order.track');

/*
|--------------------------------------------------------------------------
| Authenticated profile (admin)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Administration area
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::get('/', AdminDashboardController::class)->name('dashboard');

        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
        Route::patch('orders/{order}/courier', [AdminOrderController::class, 'assignCourier'])->name('orders.assign');

        Route::get('couriers', [AdminCourierController::class, 'index'])->name('couriers.index');
        Route::post('couriers', [AdminCourierController::class, 'store'])->name('couriers.store');
        Route::delete('couriers/{courier}', [AdminCourierController::class, 'destroy'])->name('couriers.destroy');

        Route::get('contacts', [AdminContactController::class, 'index'])->name('contacts.index');
        Route::get('contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
        Route::patch('contacts/{contact}', [AdminContactController::class, 'update'])->name('contacts.update');
        Route::delete('contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');

        Route::get('settings', [AdminSettingController::class, 'edit'])->name('settings.edit');
        Route::patch('settings', [AdminSettingController::class, 'update'])->name('settings.update');
    });

/*
|--------------------------------------------------------------------------
| Courier app (PWA)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:courier'])
    ->prefix('courier')
    ->name('courier.')
    ->group(function (): void {
        Route::get('/', [CourierController::class, 'dashboard'])->name('dashboard');
        Route::get('orders/{order}', [CourierController::class, 'show'])->name('orders.show');
        Route::post('orders/{order}/pickup', [CourierController::class, 'confirmPickup'])->name('orders.pickup');
        Route::post('orders/{order}/deliver', [CourierController::class, 'confirmDelivery'])->name('orders.deliver');
    });

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Payment gateway (Kashier) callbacks
|--------------------------------------------------------------------------
*/
Route::get('webhooks/kashier', [KashierWebhookController::class, 'returnRedirect'])->name('kashier.return');
Route::post('webhooks/kashier', [KashierWebhookController::class, 'handle'])->name('kashier.webhook');
