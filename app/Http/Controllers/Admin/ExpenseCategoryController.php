<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $categories = ExpenseCategory::withCount('expenses')->orderBy('name')->get();
        return view('admin.expense-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.expense-categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:120'],
        ]);
        ExpenseCategory::create($data);
        return redirect()->route('admin.expense-categories.index')->with('success', 'Kategori dibuat.');
    }

    public function edit(ExpenseCategory $expenseCategory)
    {
        return view('admin.expense-categories.edit', ['category' => $expenseCategory]);
    }

    public function update(Request $request, ExpenseCategory $expenseCategory)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:120'],
        ]);
        $expenseCategory->update($data);
        return redirect()->route('admin.expense-categories.index')->with('success', 'Kategori diperbarui.');
    }

    public function destroy(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->delete();
        return redirect()->route('admin.expense-categories.index')->with('success', 'Kategori dihapus.');
    }
}