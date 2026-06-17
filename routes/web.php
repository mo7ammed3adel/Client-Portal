<?php

use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\InvoiceController as AdminInvoiceController;
use App\Http\Controllers\Admin\RequestController as AdminRequestController;
use App\Http\Controllers\Client\BillingController;
use App\Http\Controllers\Client\InvoicePaymentController;
use App\Http\Controllers\Client\RequestController as ClientRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Webhooks\KashierWebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::view('/policies', 'policies')->name('policies');

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'role:client'])
    ->prefix('client')
    ->name('client.')
    ->group(function (): void {
        Route::resource('requests', ClientRequestController::class)
            ->only(['index', 'create', 'store', 'show'])
            ->parameters(['requests' => 'task']);
        Route::get('billing', BillingController::class)->name('billing.index');
        Route::post('billing/pay', [InvoicePaymentController::class, 'store'])->name('billing.pay.new');
        Route::post('billing/{invoice}/pay', InvoicePaymentController::class)->name('billing.pay');
    });

Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::resource('clients', AdminClientController::class)->except(['show']);
        Route::get('requests', [AdminRequestController::class, 'index'])->name('requests.index');
        Route::patch('requests/{task}', [AdminRequestController::class, 'update'])->name('requests.update');
        Route::resource('invoices', AdminInvoiceController::class)->only(['index', 'create', 'store', 'update']);
    });

require __DIR__.'/auth.php';

Route::get('webhooks/kashier', [KashierWebhookController::class, 'returnRedirect'])->name('kashier.return');
Route::post('webhooks/kashier', [KashierWebhookController::class, 'handle'])->name('kashier.webhook');
