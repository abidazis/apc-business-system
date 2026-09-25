<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CustomerRequest;
use App\Models\Customer;
use App\Services\Activity;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::withCount('orders')
            ->withSum('orders', 'total')
            ->when($request->get('q'), fn ($q, $term) => $q->where('name', 'like', "%{$term}%")
                ->orWhere('organization', 'like', "%{$term}%")
                ->orWhere('phone', 'like', "%{$term}%"))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    public function create(Request $request)
    {
        $redirectTo = $request->get('redirect_to');

        return view('admin.customers.create', compact('redirectTo'));
    }

    public function show(Customer $customer)
    {
        $customer->load(['orders' => fn ($q) => $q->latest()->limit(10), 'orders.payments']);

        return view('admin.customers.show', compact('customer'));
    }

    public function store(CustomerRequest $request)
    {
        $customer = Customer::create($request->validated());
        Activity::record('customer.created', $customer);

        $redirectTo = $request->get('redirect_to');
        if ($redirectTo) {
            $url = parse_url($redirectTo);
            $baseUrl = $url['path'] ?? '/admin/orders/create';
            $query = [];
            if (isset($url['query'])) {
                parse_str($url['query'], $query);
            }
            $query['customer'] = $customer->id;
            $redirectUrl = $baseUrl.'?'.http_build_query($query);

            return redirect()->to($redirectUrl)->with('success', 'Customer dibuat.');
        }

        return redirect()->route('admin.customers.index')->with('success', 'Customer ditambahkan.');
    }

    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
        Activity::record('customer.updated', $customer);

        return redirect()->route('admin.customers.index')->with('success', 'Customer diperbarui.');
    }

    public function destroy(Customer $customer)
    {
        $id = $customer->id;
        $customer->delete();
        Activity::record('customer.deleted', null, ['customer_id' => $id]);

        return redirect()->route('admin.customers.index')->with('success', 'Customer dihapus.');
    }
}
