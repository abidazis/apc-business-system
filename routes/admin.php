<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest admin routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    });

    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');

    // Authenticated admin area
    Route::middleware(['auth'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        // Resources
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class);
        Route::resource('leads', \App\Http\Controllers\Admin\LeadController::class);
        Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
        Route::post('orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');

        // Production Kanban
        Route::get('production', [\App\Http\Controllers\Admin\ProductionController::class, 'index'])->name('production.index');

        // Payments
        Route::resource('payments', \App\Http\Controllers\Admin\PaymentController::class);

        // Expenses
        Route::resource('expenses', \App\Http\Controllers\Admin\ExpenseController::class);
        Route::resource('expense-categories', \App\Http\Controllers\Admin\ExpenseCategoryController::class);

        // Invoices
        Route::resource('invoices', \App\Http\Controllers\Admin\InvoiceController::class);
        Route::get('invoices/{invoice}/pdf', [\App\Http\Controllers\Admin\InvoiceController::class, 'pdf'])->name('invoices.pdf');

        // Portfolio
        Route::resource('portfolio', \App\Http\Controllers\Admin\PortfolioController::class);
        Route::post('portfolio/{portfolio}/images', [\App\Http\Controllers\Admin\PortfolioController::class, 'uploadImage'])->name('portfolio.images.upload');
        Route::delete('portfolio-images/{image}', [\App\Http\Controllers\Admin\PortfolioController::class, 'deleteImage'])->name('portfolio.images.delete');

        // Settings, Reports, FAQ, Pages
        Route::get('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
        Route::post('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
        Route::get('reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
        Route::resource('faqs', \App\Http\Controllers\Admin\FaqController::class)->except(['show']);
        Route::resource('pages', \App\Http\Controllers\Admin\PageController::class)->except(['show']);
    });
});