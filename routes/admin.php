<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExpenseCategoryController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
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
        Route::post('/login', [AuthController::class, 'login'])
            ->middleware('throttle:5,1')
            ->name('login.attempt');
    });

    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');

    // Authenticated admin area
    Route::middleware(['auth', 'admin.active'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        // Users (Super Admin only - managed by Gate)
        Route::resource('users', UserController::class);
        Route::patch('users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');

        // Resources
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('customers', CustomerController::class);
        Route::resource('leads', LeadController::class);
        Route::post('leads/{lead}/convert-to-customer', [LeadController::class, 'convertToCustomer'])->name('leads.convert-to-customer');
        Route::resource('orders', OrderController::class);
        Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');

        // Production Kanban
        Route::get('production', [ProductionController::class, 'index'])->name('production.index');

        // Payments
        Route::resource('payments', PaymentController::class);

        // Expenses
        Route::resource('expenses', ExpenseController::class);
        Route::resource('expense-categories', ExpenseCategoryController::class);

        // Invoices
        Route::resource('invoices', InvoiceController::class);
        Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'pdf'])->name('invoices.pdf');

        // Portfolio
        Route::resource('portfolio', PortfolioController::class);
        Route::post('portfolio/{portfolio}/images', [PortfolioController::class, 'uploadImage'])->name('portfolio.images.upload');
        Route::delete('portfolio-images/{image}', [PortfolioController::class, 'deleteImage'])->name('portfolio.images.delete');

        // Settings, Reports, FAQ, Pages
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::resource('faqs', FaqController::class)->except(['show']);
        Route::resource('pages', PageController::class)->except(['show']);
    });
});
