<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Lead;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\PortfolioProject;
use App\Models\Product;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Page;
use App\Models\Faq;
use App\Models\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Anonymous Blade components: <x-admin::page-header />, <x-admin::empty-state />
        Blade::anonymousComponentPath(resource_path('views/admin/components'), 'admin');
        // Shared product card component on public site: <x-product-card />
        Blade::anonymousComponentPath(resource_path('views/partials'));

        // Gates: server-side authorization for admin area.
        // - super_admin: full access
        // - admin: orders/customers/products/production/invoice/payment
        // - staff: read-only on most, no destructive operations
        Gate::define('admin.access', fn (User $u) => $u->isAdmin() && $u->isActive());

        $manageAll = fn (User $u) => $u->isSuperAdmin();

        foreach ([
            Product::class,
            Category::class,
            PortfolioProject::class,
            Setting::class,
            Page::class,
            Faq::class,
        ] as $model) {
            $base = class_basename($model);
            Gate::define("{$base}.manage", $manageAll);
        }

        // Finance-related — super_admin only
        foreach ([Expense::class, Payment::class, Invoice::class] as $model) {
            $base = class_basename($model);
            Gate::define("{$base}.manage", $manageAll);
            Gate::define("{$base}.view", fn (User $u) => $u->isAdmin() && $u->isActive());
        }

        // Operations — admin & super_admin
        foreach ([Order::class, Customer::class, Lead::class] as $model) {
            $base = class_basename($model);
            Gate::define("{$base}.manage", fn (User $u) => $u->isAdmin() && $u->isActive());
            Gate::define("{$base}.view", fn (User $u) => $u->isAdmin() && $u->isActive());
        }
    }
}
