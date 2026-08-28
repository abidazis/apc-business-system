<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExpenseRequest;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $expenses = Expense::with('category')
            ->when($request->get('q'), fn ($q, $term) => $q->where('description', 'like', "%{$term}%"))
            ->when($request->get('category'), fn ($q, $id) => $q->where('expense_category_id', $id))
            ->when($request->get('from'), fn ($q, $d) => $q->where('date', '>=', $d))
            ->when($request->get('to'), fn ($q, $d) => $q->where('date', '<=', $d))
            ->latest('date')
            ->paginate(25)
            ->withQueryString();

        $categories = ExpenseCategory::orderBy('name')->get();
        return view('admin.expenses.index', compact('expenses', 'categories'));
    }

    public function create()
    {
        $categories = ExpenseCategory::orderBy('name')->get();
        return view('admin.expenses.create', compact('categories'));
    }

    public function store(ExpenseRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        Expense::create($data);
        return redirect()->route('admin.expenses.index')->with('success', 'Pengeluaran dicatat.');
    }

    public function edit(Expense $expense)
    {
        $categories = ExpenseCategory::orderBy('name')->get();
        return view('admin.expenses.edit', compact('expense', 'categories'));
    }

    public function update(ExpenseRequest $request, Expense $expense)
    {
        $expense->update($request->validated());
        return redirect()->route('admin.expenses.index')->with('success', 'Pengeluaran diperbarui.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('admin.expenses.index')->with('success', 'Pengeluaran dihapus.');
    }
}