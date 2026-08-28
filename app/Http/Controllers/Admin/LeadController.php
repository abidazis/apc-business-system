<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LeadRequest;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $leads = Lead::with('customer', 'assignee')
            ->when($request->get('q'), fn ($q, $term) =>
                $q->where('contact_name', 'like', "%{$term}%")
                  ->orWhere('organization', 'like', "%{$term}%")
                  ->orWhere('phone', 'like', "%{$term}%"))
            ->when($request->get('status'), fn ($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(20)
            ->withQueryString();
        return view('admin.leads.index', compact('leads'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $users = User::where('is_active', true)->orderBy('name')->get();
        return view('admin.leads.create', compact('customers', 'users'));
    }

    public function store(LeadRequest $request)
    {
        Lead::create($request->validated());
        return redirect()->route('admin.leads.index')->with('success', 'Lead ditambahkan.');
    }

    public function show(Lead $lead)
    {
        $lead->load('customer', 'assignee');
        return view('admin.leads.show', compact('lead'));
    }

    public function edit(Lead $lead)
    {
        $customers = Customer::orderBy('name')->get();
        $users = User::where('is_active', true)->orderBy('name')->get();
        return view('admin.leads.edit', compact('lead', 'customers', 'users'));
    }

    public function update(LeadRequest $request, Lead $lead)
    {
        $lead->update($request->validated());
        return redirect()->route('admin.leads.index')->with('success', 'Lead diperbarui.');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('admin.leads.index')->with('success', 'Lead dihapus.');
    }
}
